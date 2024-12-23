import random

# Function to generate SQL queries
def generate_sql_query(experience_id, weather_ids):
    num_weather = random.randint(0, 2)  # Generate random number of weather connections
    chosen_weather_ids = random.sample(weather_ids, num_weather)
    queries = []
    for weather_id in chosen_weather_ids:
        query = f"INSERT INTO Experience_Maneuver (experience_id, maneuver_id) VALUES ({experience_id}, {weather_id});"
        queries.append(query)
    return queries

# Function to write SQL queries to a file
def write_sql_file(queries):
    with open("insert_queries.sql", "w") as sql_file:
        for query in queries:
            sql_file.write(query + "\n")

# Generate 300 experience IDs
experience_ids = list(range(1, 302))

# Generate 5 weather IDs
weather_ids = list(range(1, 6))

# Generate and write SQL queries
all_queries = []
for experience_id in experience_ids:
    queries = generate_sql_query(experience_id, weather_ids)
    all_queries.extend(queries)

write_sql_file(all_queries)
print("done")
