import requests

# Global variable to hold the fetched ML responses (intent_key -> response mapping)
response_dict = {}

def fetch_ml_responses():
    """Fetches ML responses from the Laravel API endpoint (http://localhost/api/ml-responses) and returns a dict mapping intent_key to response."""
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
    return response_dict

# ... existing code ... 