import json
import random

# Specify the path to your JSON file
file_path = 'final_project_table_experience.json'
updated_file_path = 'final_project_table_experience_updated.json'

# Open the JSON file
with open(file_path, 'r') as file:
    # Load the JSON data
    data = json.load(file)

for item in data:
    item['maneuver_id'] = str(random.randint(1, 5))
    item['road_id'] = str(random.randint(1, 5))
    item['traffic_id'] = str(random.randint(1, 5))
    item['weather_id'] = str(random.randint(1, 5))

# Save the updated JSON data
with open(updated_file_path, 'w') as file:
    json.dump(data, file, indent=4)