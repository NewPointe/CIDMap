/*
#########################################
###  Global Constants and Variables:  ###
#########################################
*/
var debug = true;
var verbose = true;

var geocoder;
var theMap;
var theInfoWindow = null;

var MapAPI = {
    BaseUrl: "http://maps.googleapis.com/maps/api/js?",
    Key: "AIzaSyCC3roJ2AMv20nRAnYd4MFK-cmFjoMcGo4",
    Sensor: true,
    Libraries: ["visualization"],
    onLoad: "setupMap"
}

var MapData = {
    Campuses: [["Dover", 40.504756,-81.540552],
               ["Canton", 40.856902,-81.418123],
               ["Millersburg", 40.559279,-81.942299]],
    CampusLogo:"logo.png",
    CampusMarker:"marker-green.png",
    CIDLocations: null,
    CIDMarker: null
}

var MapOptions = null;
          
/*
#########################################
###    Main Functions and Methods:    ###
#########################################
*/

// General HTMLDom function shortcuts:
getById = function(id) { return document.getElementById(id); }
getByName = function(id) { return document.getElementsByTagName(id); }


// To load the GoogleMapAPI on-demand:
loadMapApi = function() {
    
    // Put together the url:
    var url = MapAPI.BaseUrl + "key=" + MapAPI.Key + "&sensor=" +
              MapAPI.Sensor + "&libraries=" + MapAPI.Libraries +
              "&callback=" + MapAPI.onLoad;
    
    // Create a <script> tag for it:
    var script = document.createElement('script');
    script.type= 'text/javascript';
    script.src= url;
    
    // And put it into the <head> section
    var head = getByName('head')[0];
    head.appendChild(script);
    
}

// To find the info for an address when geocode() returns:
getAddressInfo = function(address){
    
    // Iterate through all the locations
    for(var loc = 0; loc < MapData.CIDLocations; loc++){
        
        // If the location is at the address, return that location
        if(MapData.CIDLocations[loc][2] == address){
            return MapData.CIDLocations[loc];
        }
    }
    
    if(debug) console.log("Couldn't find a project at <" + address + ">")
    
    // If we made it this far, we didn't find anything, so return nothing
    return null;
}

// To geocode an address. Needs a callback function bacause it's asynchronous!
geocode = function(address, callback){
    geocoder.geocode( { 'address': address }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            callback(results, status);
        }
        else {
            if(debug) {
                if(verbose){
                    console.log("Geocode failed with status of <" + status 
                                + "> when attempting to geocode <" + address
                                + ">");
                }
                else{
                    console.log("[Geocode Failed]: " + status);   
                }
            }
        }
    });
}

// To set up the campus points on the map
setCampusMarkers = function(map, locations){
    
    for (var loc = 0; loc < locations.length; loc++) {
            var campus = locations[loc];
            var themarker = new google.maps.Marker({
                map: map,
                icon: MapData.CIDMarker,
                position: new google.maps.LatLng(MapData.Campuses[loc][1], MapData.Campuses[loc][2]),
                title: campus[0],
                zIndex: loc,
                html: campus[2],
                animation: google.maps.Animation.DROP
            });
            google.maps.event.addListener(themarker, 'click', function() {
                theInfoWindow.setContent(this.html);
                theInfoWindow.open(map, this);
            });
    }
    
}

// To set up the location points on the map
setLocationMarkers = function(map, locations){
    
    for (var loc = 0; loc < locations.length; loc++) {
        geocode(locations[loc][1], function(results, status){
            var campus = getAddressInfo(results[0].formatted_address)
            if(campus != null) {
                var themarker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
                    title: campus[0],
                    zIndex: loc,
                    html: campus[2],
                    animation: google.maps.Animation.DROP
                });
                google.maps.event.addListener(themarker, 'click', function() {
                    infowindow.setContent(this.html);
                    infowindow.open(map, this);
                });
            }
            else{
                if(debug) {
                    console.log("Could not add point because getAddressInfo() returned null.");
                }                
            }
        })
    }
}

// Setup the map once the API is loaded
setupMap = function() {
    
    geocoder = new google.maps.Geocoder();
    
    theInfoWindow = new google.maps.InfoWindow({
        content: "<content here>"
    });
    
    MapOptions = {
        zoom: 10,
        center: new google.maps.LatLng(MapData.Campuses[0][1], MapData.Campuses[0][2]),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    
    theMap = new google.maps.Map(getById("map_canvas"), MapOptions);
    
    
    MapData.CIDLocations = projectlocations; // projectlocations is defined in the
                                         // html file so the php works
    
    
    setCampusMarkers(theMap, MapData.Campuses);
    setLocationMarkers(theMap, MapData.CIDLocations);
    
}

