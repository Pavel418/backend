CREATE TABLE Weather
(
  weather_id INT NOT NULL,
  weather VARCHAR(20) NOT NULL,
  PRIMARY KEY (weather_id)
);

CREATE TABLE Road
(
  road_id INT NOT NULL,
  road VARCHAR(20) NOT NULL,
  PRIMARY KEY (road_id)
);

CREATE TABLE Navigation
(
  navigation_id INT NOT NULL,
  navigation VARCHAR(20) NOT NULL,
  PRIMARY KEY (navigation_id)
);

CREATE TABLE Maneuver
(
  maneuver VARCHAR(20) NOT NULL,
  maneuver_id INT NOT NULL,
  PRIMARY KEY (maneuver_id)
);

CREATE TABLE Traffic
(
  traffic_id INT NOT NULL,
  traffic VARCHAR(20) NOT NULL,
  PRIMARY KEY (traffic_id)
);

CREATE TABLE Experience
(
  depart_time INT NOT NULL,
  arrival_time INT NOT NULL,
  date INT NOT NULL,
  experience_id INT NOT NULL,
  distance INT NOT NULL,
  navigation_id INT NOT NULL,
  PRIMARY KEY (experience_id),
  FOREIGN KEY (navigation_id) REFERENCES Navigation(navigation_id)
);

CREATE TABLE Experience_Weather
(
  experience_id INT NOT NULL,
  weather_id INT NOT NULL,
  PRIMARY KEY (experience_id, weather_id),
  FOREIGN KEY (experience_id) REFERENCES Experience(experience_id),
  FOREIGN KEY (weather_id) REFERENCES Weather(weather_id)
);

CREATE TABLE Experience_Road
(
  experience_id INT NOT NULL,
  road_id INT NOT NULL,
  PRIMARY KEY (experience_id, road_id),
  FOREIGN KEY (experience_id) REFERENCES Experience(experience_id),
  FOREIGN KEY (road_id) REFERENCES Road(road_id)
);

CREATE TABLE Experience_Maneuver
(
  experience_id INT NOT NULL,
  maneuver_id INT NOT NULL,
  PRIMARY KEY (experience_id, maneuver_id),
  FOREIGN KEY (experience_id) REFERENCES Experience(experience_id),
  FOREIGN KEY (maneuver_id) REFERENCES Maneuver(maneuver_id)
);

CREATE TABLE Experience_Traffic
(
  traffic_id INT NOT NULL,
  experience_id INT NOT NULL,
  PRIMARY KEY (traffic_id, experience_id),
  FOREIGN KEY (traffic_id) REFERENCES Traffic(traffic_id),
  FOREIGN KEY (experience_id) REFERENCES Experience(experience_id)
);