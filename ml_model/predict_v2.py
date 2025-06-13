import joblib
import re
import sys
import os
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.naive_bayes import MultinomialNB
from sklearn.multiclass import OneVsRestClassifier
from sklearn.preprocessing import MultiLabelBinarizer
import requests

# Add parent directory to path to import intent_data
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))

# Load Version B models
try:
    classifier = joblib.load('/ml_model/chat_model_v2.pkl')
    vectorizer = joblib.load('/ml_model/vectorizer_v2.pkl')
    label_encoder = joblib.load('/ml_model/label_encoder_v2.pkl')
    sub_intent_patterns = joblib.load('/ml_model/sub_intent_patterns.pkl')
    print("✅ Version B models loaded successfully!")
except FileNotFoundError as e:
    print(f"❌ Error loading models: {e}")
    print("Please run train_model_v2.py first to create the Version B models.")
    sys.exit(1)

# Motor compatibility data
motor_tersedia = [
    "honda beat", "honda vario", "honda revo x",
    "yamaha vega force", "yamaha jupiter z1",
    "suzuki address fi", "suzuki smash fi",
    "tvs dazz", "viar star nx", "honda nmax", 
    "honda revo", "honda pcx", "honda aerox", 
    "honda scoopy", "honda vespa"
]

# Global variable to hold the fetched ML responses (intent_key -> response mapping)
response_dict = {}

def fetch_ml_responses():
    """Fetches ML responses from the Laravel API endpoint (http://localhost/api/ml-responses) and populates the global response_dict."""
    global response_dict
    try:
         r = requests.get("http://localhost/api/ml-responses")
         if r.status_code == 200:
             data = r.json()
             # Assume the API returns a list of dictionaries (each with keys 'intent_key' and 'response')
             response_dict = {item['intent_key']: item['response'] for item in data}
             print("ML responses fetched successfully.")
         else:
             print("Error fetching ML responses (status code: {})".format(r.status_code))
    except Exception as e:
         print("Exception while fetching ML responses: {}".format(e))

def get_response(intent_key, fallback_response="Maaf, saya tidak mengerti pertanyaan Anda. Silakan tanyakan hal lain."):
    """Returns the response (string) for the given intent_key (or a fallback if not found)."""
    if not response_dict:
         fetch_ml_responses()
    return response_dict.get(intent_key, fallback_response)

def detect_motor_type(user_input):
    """Detect specific motor type mentioned in user input"""
    kalimat = user_input.lower()
    detected_motors = []
    
    for motor in motor_tersedia:
        if motor in kalimat:
            detected_motors.append(motor.title())
    
    return detected_motors

def predict_sub_intents(user_input):
    """Predict sub-intents using the trained multi-label classifier"""
    # Transform input
    X = vectorizer.transform([user_input])
    
    # Predict using multi-label classifier
    predicted_binary = classifier.predict(X)
    predicted_labels = label_encoder.inverse_transform(predicted_binary)[0]
    
    # Simplified confidence scoring - use decision function for scoring
    try:
        decision_scores = classifier.decision_function(X)[0]
        label_confidence = {}
        for i, label in enumerate(label_encoder.classes_):
            # Use decision function score as confidence
            confidence = max(0, decision_scores[i])  # Ensure non-negative
            label_confidence[label] = confidence
    except:
        # Fallback: assign equal confidence to all predicted labels
        label_confidence = {label: 0.5 for label in label_encoder.classes_}
    
    # Filter and sort by confidence (lowered threshold for better results)
    confident_labels = [label for label in predicted_labels if label in label_confidence and label_confidence[label] > 0.1]
    if not confident_labels:
        confident_labels = list(predicted_labels)  # Use all predicted if none meet threshold
    
    confident_labels.sort(key=lambda x: label_confidence.get(x, 0), reverse=True)
    
    return confident_labels, label_confidence

def enhance_with_pattern_matching(user_input, predicted_labels):
    """Enhance predictions with additional pattern matching"""
    enhanced_labels = set(predicted_labels)
    user_lower = user_input.lower()
    
    # Add pattern-based detection for missed sub-intents
    for main_intent, sub_patterns in sub_intent_patterns.items():
        for sub_intent, patterns in sub_patterns.items():
            full_label = f"{main_intent}_{sub_intent}"
            if full_label not in enhanced_labels:
                for pattern in patterns:
                    if re.search(pattern, user_lower):
                        enhanced_labels.add(full_label)
                        break
    
    return list(enhanced_labels)

def generate_contextual_response(labels, user_input, detected_motors):
    """Generate contextual responses based on detected intents and context"""
    responses = []
    
    # Motor-specific context
    if detected_motors:
        motor_context = f"Untuk {', '.join(detected_motors)}: "
    else:
        motor_context = ""
    
    # Process each detected label
    for label in labels:
        if label in response_dict:
            response = response_dict[label]
            if motor_context and "produk" in response.lower():
                response = motor_context + response
            responses.append(response)
    
    # Add fallback response if no specific response found
    if not responses:
        main_intents = [label for label in labels if "_" not in label]
        if main_intents:
            for intent in main_intents:
                if intent in response_dict:
                    responses.append(response_dict[intent])
        else:
            responses.append(response_dict["general_inquiry"])
    
    return responses

def get_enhanced_response(user_input):
    """Main function to get enhanced response with sub-intent detection"""
    print(f"🔍 Analyzing: '{user_input}'")
    
    # Predict sub-intents
    predicted_labels, confidence_scores = predict_sub_intents(user_input)
    print(f"🎯 ML Predictions: {predicted_labels}")
    
    # Enhance with pattern matching
    enhanced_labels = enhance_with_pattern_matching(user_input, predicted_labels)
    print(f"🔧 Enhanced Labels: {enhanced_labels}")
    
    # Detect motor types
    detected_motors = detect_motor_type(user_input)
    if detected_motors:
        print(f"🏍️ Detected Motors: {detected_motors}")
    
    # Generate contextual responses
    responses = generate_contextual_response(enhanced_labels, user_input, detected_motors)
    
    # Show confidence scores for top predictions
    top_confidences = sorted(confidence_scores.items(), key=lambda x: x[1], reverse=True)[:3]
    print(f"📊 Top Confidences: {[(label, f'{conf:.2f}') for label, conf in top_confidences]}")
    
    return responses, enhanced_labels

def chat_interface():
    """Interactive chat interface for testing"""
    print("🤖 **CHATBOT VERSION B - SUB-INTENT DETECTION**")
    print("="*60)
    print("Ketik 'exit', 'quit', atau 'keluar' untuk mengakhiri chat")
    print("Ketik 'debug' untuk melihat detail analisis")
    print("-"*60)
    
    debug_mode = False
    
    while True:
        user_input = input("\n👤 Anda: ").strip()
        
        if user_input.lower() in ["exit", "quit", "keluar"]:
            print("🤖 Bot: Terima kasih sudah menggunakan layanan kami! 👋")
            break
        
        if user_input.lower() == "debug":
            debug_mode = not debug_mode
            print(f"🔧 Debug mode: {'ON' if debug_mode else 'OFF'}")
            continue
        
        if not user_input:
            print("🤖 Bot: Silakan masukkan pertanyaan Anda.")
            continue
        
        try:
            if debug_mode:
                responses, labels = get_enhanced_response(user_input)
                print(f"\n🏷️ Detected Labels: {labels}")
            else:
                responses, _ = get_enhanced_response(user_input)
            
            print(f"\n🤖 Bot Response{'s' if len(responses) > 1 else ''}:")
            print("-" * 40)
            
            for i, response in enumerate(responses, 1):
                if len(responses) > 1:
                    print(f"{i}. {response}\n")
                else:
                    print(f"{response}\n")
                    
        except Exception as e:
            print(f"❌ Error: {e}")
            print("Maaf, terjadi kesalahan. Silakan coba lagi.")

# Example usage and testing
if __name__ == "__main__":
    # Test examples
    test_cases = [
        "Berapa harga mounting carbon dan ada promo gak?",
        "Lampu LED projector untuk Beat masih ada stok?", 
        "Body kit Aerox ready stock berapa harga?",
        "Biaya pasang lampu DRL di rumah weekend berapa ya?",
        "Mounting phone holder waterproof harga grosir berapa?"
    ]
    
    print("🧪 **TESTING VERSION B SUB-INTENT DETECTION**")
    print("="*60)
    
    for i, test_case in enumerate(test_cases, 1):
        print(f"\n📝 Test Case {i}:")
        responses, labels = get_enhanced_response(test_case)
        print("💬 Responses:")
        for j, response in enumerate(responses, 1):
            print(f"   {j}. {response[:100]}...")
        print("-" * 60)
    
    print("\n🚀 Starting interactive chat interface...")
    chat_interface() 