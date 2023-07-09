
// Get your own API Key on https://myprojects.geoapify.com
var myAPIKey = "ce5237751f764747b6e8815253769840"; //mi clave api

// Retina displays require different mat tiles quality
var isRetina = L.Browser.retina;

//llamo api
var baseUrl =
`https://maps.geoapify.com/v1/tile/osm-bright/{z}/{x}/{y}.png?apiKey=${myAPIKey}`;
var retinaUrl =
`https://maps.geoapify.com/v1/tile/osm-bright/{z}/{x}/{y}@2x.png?apiKey=${myAPIKey}`;


//Opciones para fetch
var requestOptions = {
    method: "GET",

};
//variables coordenadas
let jsonData; 
let lat;
let lon;

//Cojo parametros de busqueda
//pais
var idcountry = document.getElementById("idcountry");
var myidcountryaux = idcountry.textContent;
var myidcountry = myidcountryaux.split(':').pop();

//calle
var idstreet = document.getElementById("idstreet");
var myidstreetaux = idstreet.textContent;
var myidstreet = myidstreetaux.split(':').pop();

//ciudad
var idcity = document.getElementById("idcity");
var myidcityaux= idcity.textContent;
var myidcity = myidcityaux.split(':').pop();

//codigo postal
var idpostalcode = document.getElementById("idpostalcode");
var myidpostalcodeaux = idpostalcode.textContent;
var myidpostalcode = myidpostalcodeaux.split(':').pop();

//Petición
async function fetchText() { 
  let response = await fetch(`https://api.geoapify.com/v1/geocode/search?street=${myidstreet}&postcode=${myidpostalcode}&city=${myidcity}&country=${myidcountry}a&format=json&apiKey=${myAPIKey}`, requestOptions); 
  let data = await response.json(); 
  jsonData = data; 
  lon=jsonData.results[0].lon;
  lat= jsonData.results[0].lat;
  return [lon,lat];
}

//Mapa con marcador
(async () => {
  let coor= await fetchText()
  lon=coor[1];
  lat=coor[0];

    const markerIcon = L.icon({
    iconUrl: `https://api.geoapify.com/v1/icon?size=xx-large&type=awesome&color=%233e9cfe&icon=paw&apiKey=${myAPIKey}`,
    iconSize: [31, 46], // size of the icon
    iconAnchor: [15.5, 42], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -45] // point from which the popup should open relative to the iconAnchor
  });
  var map = L.map("my-map").setView([lon, lat], 17);

  const zooMarker = L.marker([lon, lat], {
    icon: markerIcon
  }).addTo(map);

  // Add map tiles layer. Set 20 as the maximal zoom and provide map data attribution.
L.tileLayer(isRetina ? retinaUrl : baseUrl, {
  attribution:
    'Powered by <a href="https://www.geoapify.com/" target="_blank">Geoapify</a> | © OpenStreetMap <a href="https://www.openstreetmap.org/copyright" target="_blank">contributors</a>',
  apiKey: myAPIKey,
  maxZoom: 20,
  id: "osm-bright",
}).addTo(map);
})()
