window.onload = function() {
    function setSelectedOption(selectId, selectedValue) {
      var selectElement = document.getElementById(selectId);
      
      if (selectedValue) {
        selectElement.value = selectedValue;
      }
    }
  
    var weatherSelect = document.getElementById('weather-condition');
    var weatherId = Array.from(weatherSelect.options).find(option => option.hasAttribute('selected')).value;
    
    var roadSelect = document.getElementById('road-type');
    var roadId = Array.from(roadSelect.options).find(option => option.hasAttribute('selected')).value;
    
    var trafficSelect = document.getElementById('traffic-type');
    var trafficId = Array.from(trafficSelect.options).find(option => option.hasAttribute('selected')).value;
    
    var navigationSelect = document.getElementById('navigation-type');
    var navigationId = Array.from(navigationSelect.options).find(option => option.hasAttribute('selected')).value;
  
    setSelectedOption('weather-condition', weatherId);
    setSelectedOption('road-type', roadId);
    setSelectedOption('traffic-type', trafficId);
    setSelectedOption('navigation-type', navigationId);
  };
  