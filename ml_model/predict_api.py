#!/usr/bin/env python3
import joblib
import re
import sys
import os
import json
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.naive_bayes import MultinomialNB
from sklearn.multiclass import OneVsRestClassifier
from sklearn.preprocessing import MultiLabelBinarizer

def load_models():
    """Load the trained ML models"""
    try:
        model_path = os.path.dirname(os.path.abspath(__file__))
        
        # Try to load from ml_model subdirectory first
        model_subdir = os.path.join(model_path, 'ml_model')
        if os.path.exists(model_subdir):
            model_path = model_subdir
        
        classifier = joblib.load(os.path.join(model_path, 'chat_model_v2.pkl'))
        vectorizer = joblib.load(os.path.join(model_path, 'vectorizer_v2.pkl'))
        label_encoder = joblib.load(os.path.join(model_path, 'label_encoder_v2.pkl'))
        sub_intent_patterns = joblib.load(os.path.join(model_path, 'sub_intent_patterns.pkl'))
        
        return classifier, vectorizer, label_encoder, sub_intent_patterns
    except FileNotFoundError as e:
        return None, None, None, None

def detect_motor_type(user_input, motor_list):
    """Detect specific motor type mentioned in user input"""
    kalimat = user_input.lower()
    detected_motors = []
    
    for motor in motor_list:
        if motor.lower() in kalimat:
            detected_motors.append(motor.title())
    
    return detected_motors

def predict_sub_intents(user_input, classifier, vectorizer, label_encoder):
    """Predict sub-intents using the trained multi-label classifier"""
    try:
        # Transform input
        X = vectorizer.transform([user_input])
        
        # Predict using multi-label classifier
        predicted_binary = classifier.predict(X)
        predicted_labels = label_encoder.inverse_transform(predicted_binary)[0]
        
        # Get confidence scores
        try:
            decision_scores = classifier.decision_function(X)[0]
            label_confidence = {}
            for i, label in enumerate(label_encoder.classes_):
                confidence = max(0, decision_scores[i])
                label_confidence[label] = float(confidence)
        except:
            label_confidence = {label: 0.5 for label in label_encoder.classes_}
        
        # Filter by confidence
        confident_labels = [label for label in predicted_labels 
                          if label in label_confidence and label_confidence[label] > 0.1]
        if not confident_labels:
            confident_labels = list(predicted_labels)
        
        confident_labels.sort(key=lambda x: label_confidence.get(x, 0), reverse=True)
        
        return confident_labels, label_confidence
    except Exception as e:
        return [], {}

def enhance_with_pattern_matching(user_input, predicted_labels, sub_intent_patterns):
    """Enhance predictions with additional pattern matching"""
    enhanced_labels = set(predicted_labels)
    user_lower = user_input.lower()
    
    try:
        for main_intent, sub_patterns in sub_intent_patterns.items():
            for sub_intent, patterns in sub_patterns.items():
                full_label = f"{main_intent}_{sub_intent}"
                if full_label not in enhanced_labels:
                    for pattern in patterns:
                        if re.search(pattern, user_lower):
                            enhanced_labels.add(full_label)
                            break
    except Exception as e:
        pass
    
    return list(enhanced_labels)

def generate_contextual_response(labels, user_input, detected_motors, response_dict):
    """Generate contextual responses based on detected intents and context"""
    responses = []
    
    # Motor-specific context
    motor_context = ""
    if detected_motors:
        motor_context = f"Untuk {', '.join(detected_motors)}: "
    
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
        
        if not responses:
            if 'general_inquiry' in response_dict:
                responses.append(response_dict['general_inquiry'])
            else:
                responses.append("BANTUAN UMUM - Silakan tanyakan hal spesifik tentang produk, harga, stok, atau pemasangan. Tim customer service kami siap membantu!")
    
    return responses

def predict_intent_api(user_message, motor_list, response_dict):
    """Main API function for intent prediction"""
    # Load models
    classifier, vectorizer, label_encoder, sub_intent_patterns = load_models()
    
    if not all([classifier, vectorizer, label_encoder, sub_intent_patterns]):
        return {
            "error": "Failed to load ML models",
            "responses": ["Maaf, terjadi kesalahan dalam sistem. Silakan hubungi customer service."],
            "intents": [],
            "confidence": 0
        }
    
    try:
        # Predict sub-intents
        predicted_labels, confidence_scores = predict_sub_intents(
            user_message, classifier, vectorizer, label_encoder
        )
        
        # Enhance with pattern matching
        enhanced_labels = enhance_with_pattern_matching(
            user_message, predicted_labels, sub_intent_patterns
        )
        
        # Detect motor types
        detected_motors = detect_motor_type(user_message, motor_list)
        
        # Generate contextual responses
        responses = generate_contextual_response(
            enhanced_labels, user_message, detected_motors, response_dict
        )
        
        # Calculate average confidence
        avg_confidence = 0
        if confidence_scores:
            relevant_confidences = [confidence_scores.get(label, 0) for label in enhanced_labels]
            if relevant_confidences:
                avg_confidence = sum(relevant_confidences) / len(relevant_confidences)
        
        return {
            "responses": responses,
            "intents": enhanced_labels,
            "detected_motors": detected_motors,
            "confidence": float(avg_confidence),
            "raw_predictions": predicted_labels
        }
        
    except Exception as e:
        return {
            "error": str(e),
            "responses": ["Maaf, terjadi kesalahan dalam memproses pertanyaan Anda. Silakan coba lagi."],
            "intents": [],
            "confidence": 0
        }

if __name__ == "__main__":
    try:
        # Get arguments from command line
        if len(sys.argv) < 4:
            error_result = {
                "error": "Insufficient arguments",
                "responses": ["Error: Missing required arguments"],
                "intents": [],
                "confidence": 0
            }
            print(json.dumps(error_result, ensure_ascii=True))
            sys.exit(1)
        
        # Parse JSON arguments
        user_message = json.loads(sys.argv[1])
        motor_list = json.loads(sys.argv[2])
        response_dict = json.loads(sys.argv[3])
        
        # Get prediction
        result = predict_intent_api(user_message, motor_list, response_dict)
        
        # Return JSON response - use ensure_ascii=True for Windows compatibility
        print(json.dumps(result, ensure_ascii=True))
        
    except json.JSONDecodeError as e:
        error_result = {
            "error": f"JSON decode error: {str(e)}",
            "responses": ["Error: Invalid JSON input"],
            "intents": [],
            "confidence": 0
        }
        print(json.dumps(error_result, ensure_ascii=True))
        sys.exit(1)
    except Exception as e:
        error_result = {
            "error": f"Unexpected error: {str(e)}",
            "responses": ["Error: Unexpected system error"],
            "intents": [],
            "confidence": 0
        }
        print(json.dumps(error_result, ensure_ascii=True))
        sys.exit(1) 