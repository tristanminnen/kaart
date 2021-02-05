<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link href="https://fonts.googleapis.com/css?family=Dosis:300,400,700" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <script src="script.js"></script>
    <style>
        #map { height: 100vh; }
    </style>

    <meta charset="UTF-8">
    <title>Title</title>

</head>

<body>
<?php
//Kijken welke Kaart laten zien

// de URL die geopent moet worden
$url = "api.openweathermap.org/data/2.5/weather?q=Rotterdam&appid=bb42ac1606a7aa914e2eaa795f40550a";

//initialseer een cURL handle
$ch = curl_init();

//stel opties in
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


//voer de cURL opdracht uit
$data = curl_exec($ch);


//sluit de cURL handle
curl_close($ch);

$phpArray = json_decode($data);

//echo "<pre>";
//print_r($phpArray);
//echo "<pre>";



//tijd

$opkom = $phpArray->sys->sunrise;
$opkomst = date('H:i', $opkom);
//echo "zons opkomst = " . $opkomst . "<br>";

$onder = $phpArray->sys->sunset;
$ondergang = date('H:i', $onder);
//echo "zons ondergang = " . $ondergang . "<br><br>";


//wind snelhied
$wind = $phpArray->wind->speed;
$snelheid = $wind * 3.6;
//echo "windsnelheid = " . $snelheid . "<br><br>";


$temp = $phpArray->main->temp;
$celsius = $temp - 273.15;
//echo "Temperatuur = " . $celsius;


$weer = $phpArray->weather->main;
if ($weer == "clear sky"){
    $kaart1 = "zon";
}elseif ($weer == "few clouds" ){
    $kaart1 = "zon";
}elseif ($weer == "shower rain"){
    $kaart1 = "regen.jpg";
}elseif ($weer == "rain"){
    $kaart1 = "regen.jpg";
}elseif ($weer == "thunderstorm"){
    $kaart1 = "regen.jpg";
} else{
    $kaart1 = "wolken";
}

$tijd = date('H:i');
$timestamp = strtotime($opkomst) + 4*60*60;

$middag = date('H:i', $timestamp);


if ($tijd < $opkomst){
    $kaart2 = "nacht";
}elseif ($tijd < $middag){
    $kaart2 = "ochtend";
}elseif ($tijd <$ondergang){
    $kaart2 = "middag";
}elseif ($kaart1 == "regen"){
    $kaart2 = "";
}else{
    $kaart2 = "avond";
}

?>



<div id="map">
    <div class="scroll-menu"></div>
</div>


<!-- voeg apparte modals toe -->

<!-- Wolveik -->
<div class="modal fade" id="Wolveik" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close py-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <h5 class="modal-title mt-1" id="exampleModalLongTitle">Wolveik</h5>
                <p>Wolveik once was the location of an ancient elven settlement, which upon the great eastern expansion of humans approximately five hundred years ago, was abandoned by the elves and in its place humans built this city.</p>
            </div>
        </div>
    </div>
</div>

<!-- Drakenhoff -->
<div class="modal fade" id="Drakenhoff" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close py-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <h5 class="modal-title mt-1" id="exampleModalLongTitle">Drakenhoff</h5>
                <p>Drakenhoff is a free city within Redania and is therefore not subject to the rule of that kingdom. It is one of the major ports on the continent and populated by nearly 30,000 inhabitants, making it one of the largest cities in the south.
                    Like any true metropolis, Drakenhoff has many factories and is home to all manner of craftsmen offering every ware possible and one can even find the occasional con-man or shady dealer. The city is also home to numerous banks and even has a zoo. The Eternal Fire is said to protect the city's inhabitants from all evil, monsters included. The thick city walls have never been breached, as they were tactfully designed by the architects of the Oxenfurt Academy.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- haunted -->
<div class="modal fade" id="Hounted" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close py-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <h5 class="modal-title mt-1" id="exampleModalLongTitle">Hounted Woods</h5>
                <p>Hounted Woods was the former capital of the province of Sylvania during the rule of its last Imperial Count, Otto von Drak. Though the town is considered the original "official" capital of the province, nearly all the rulers of Sylvania, both living and undead, has made the Castle as their seat of power. This accursed citadel was where Vlad von Carstein began his reign of terror, and from which battlements he summoned his Undead army. It was home to generations of von Draks before Vlad came, and some say it is the home of Mannfred von Carstein to this day. Adventurers still seeking the towering castle out because of the treasure trove of occult lore rumored to be contained in its library. It is said that copies of all the great sorcerers' works can be found there, shackled tight to shelves made from wood that bleeds scarlet in the candlelight, but no one who has sought them has ever returned.[</p>
            </div>
        </div>
    </div>
</div>

<!-- sandaro -->
<div class="modal fade" id="Sandaro" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close py-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <h5 class="modal-title mt-1" id="exampleModalLongTitle">Sandaro</h5>
                <p>Sandaro is a Small village on the side of a desert and ones was a giant city in th3e time of the pharaos but after the fall it was abandoned. hundreds of years pass and some wanders found the ruins and moved in and rebuild the city brick by brick.</p>
            </div>
        </div>
    </div>
</div>

<!-- Pharao -->
<div class="modal fade" id="Pharao" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close py-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <h5 class="modal-title mt-1" id="exampleModalLongTitle">Pharao rest</h5>
                <p>As Settra lay dying, full of anger and pride to his last breath, the priests of the Mortuary Cult promised him a golden paradise that, upon his awakening, he would rule for millions of years. When the king perished, it was with a curse on his lips. Powerful incantations were intoned over his corpse and he was embalmed in a great ritual. Preserved against decay, the body of Settra was entombed within a mighty sarcophagus in the heart of a majestic pyramid of shining white stone. The monument was so bright that it hurt mortal eyes just to look upon it. The pyramid was vast and it towered over the city of Khemri. It was the largest and most magnificent monument ever created in Nehekhara, for no simple cairne would befit a king as might and powerful as Settra.</p>
            </div>
        </div>
    </div>
</div>


<!-- Tree -->
<div class="modal fade" id="Tree" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close py-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <h5 class="modal-title mt-1" id="exampleModalLongTitle">World Tree</h5>
                <p>World tree, also called cosmic tree, centre of the world, a widespread motif in many myths and folktales among various preliterate peoples, especially in Asia, Australia, and North America, by which they understand the human and profane condition in relation to the divine and sacred realm. Two main forms are known and both employ the notion of the world tree as centre. In the one, the tree is the vertical centre binding together heaven and earth; in the other, the tree is the source of life at the horizontal centre of the earth. Adopting biblical terminology, the former may be called the tree of knowledge; the latter, the tree of life.
                </p>
            </div>
        </div>
    </div>
</div>


<!-- Moandoa -->
<div class="modal fade" id="Moandoa" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close py-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <h5 class="modal-title mt-1" id="exampleModalLongTitle">Moandoa</h5>
                <p>Moandoa is the capital city of the Grand Province of Averland, and the original capital of the ancient Brigundians tribe. Averheim has been the chief city of the land between the river Aver and the river Reik since before the legendary Emperor Sigmar was born. It sits on a bluff above the river Aver, and so is immune from its occasional high floods. At the highest point of the city, at the end of the road leading from the towns of Pfungzig and Heideck, the fortress of the Elector Count sits behind powerful walls from which its towers command a view for miles around.    </p>
            </div>
        </div>
    </div>
</div>


<!-- Lake -->
<div class="modal fade" id="Lake" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close py-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <h5 class="modal-title mt-1" id="exampleModalLongTitle">Lake Town</h5>
                <p>Lake-town, or Esgaroth (known fully as "Esgaroth upon the Long Lake"), was a small settlement of Men in the north-western part of the Long Lake in Rhovanion. The town was constructed entirely of wood and stands upon wooden pillars sunk into the bed of the Long Lake, south of the Lonely Mountain and east of Mirkwood. It seems that the town's prosperity was built on trade between the Men, Elves, and Dwarves of northern Middle-earth.[1]</p>
            </div>
        </div>
    </div>
</div>


<!-- compas -->
<div class="modal fade" id="Compas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close py-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <h5 class="modal-title mt-1" id="exampleModalLongTitle">Info</h5>
                <!-- voegt snelle teleport toe -->
                <p data-dismiss="modal" aria-label="Close" onclick="locWolveik()">Wolveik</p>
                <p data-dismiss="modal" aria-label="Close" onclick="locDrakenhoff()">Drakenhoff</p>
                <p data-dismiss="modal" aria-label="Close" onclick="locSandaro()">Sandaro</p>
                <p data-dismiss="modal" aria-label="Close" onclick="locPharao()">Pharao Rest</p>
                <p data-dismiss="modal" aria-label="Close" onclick="locHaunted()">Houndted Woods</p>
                <p data-dismiss="modal" aria-label="Close" onclick="locLake()">Lake Town</p>
                <p data-dismiss="modal" aria-label="Close" onclick="locTree()">World Tree</p>
                <p data-dismiss="modal" aria-label="Close" onclick="locMoandoa()">Moandoa</p>
            </div>
        </div>
    </div>
</div>












<script>

    // bepaalt aan het weer en tijd welke kaart hij moet laten zien
    var map = L.map('map', {
        crs: L.CRS.Simple,
        minZoom: -5
    });
    var bounds = [[0,0], [1536,2048]];
    var image = L.imageOverlay('img/kaart/<?php echo $kaart1 . $kaart2. ".jpg"; ?>', bounds).addTo(map);

    map.fitBounds(bounds);



//voegt klikbaar gebied toe aan de plaatsen
    var Wolveik = L.polygon([
        [1536, 1350],
        [1536, 1600],
        [1340, 1600],
        [1340, 1350]
    ], {
        color: 'rgba(255,0,51,0)',
        fillColor: '#f03',
        fillOpacity: 0,
    }).addTo(map).on('click', function(e) { $('#Wolveik').modal('show');});

    function locWolveik() {
        map.setView([1400, 1400], 1);
    }



    var compas = L.circle([1379, 1888], {
        color: 'rgba(255,0,51,0)',
        fillColor: '#f03',
        fillOpacity: 0,
        radius: 121
    }).addTo(map).on('click', function(e) { $('#Compas').modal('show');});



    var Drakenhoff = L.circle([650, 860], {
        color: 'rgba(255,0,51,0)',
        fillColor: '#f03',
        fillOpacity: 0,
        radius: 160
    }).addTo(map).on('click', function(e) { $('#Drakenhoff').modal('show');});

    function locDrakenhoff() {
        map.setView([650, 860], 1);
    }


    var Hounted = L.circle([180, 600], {
        color: 'rgba(255,0,51,0)',
        fillColor: '#f03',
        fillOpacity: 0,
        radius: 160
    }).addTo(map).on('click', function(e) { $('#Hounted').modal('show');});

    function locHaunted() {
        map.setView([180, 600], 1);
    }


    var Sandora = L.circle([650, 1650], {
        color: 'rgba(255,0,51,0)',
        fillColor: '#ff0033',
        fillOpacity: 0,
        radius: 140
    }).addTo(map).on('click', function(e) { $('#Sandaro').modal('show');});

    function locSandaro() {
        map.setView([650, 1650], 1);
    }

    var Pharao = L.circle([270, 1620], {
        color: 'rgba(255,0,51,0)',
        fillColor: '#ff0033',
        fillOpacity: 0,
        radius: 180
    }).addTo(map).on('click', function(e) { $('#Pharao').modal('show');});

    function locPharao() {
        map.setView([270, 1620], 1);
    }

    var Lake = L.circle([600, 100], {
        color: 'rgba(255,0,51,0)',
        fillColor: '#ff0033',
        fillOpacity: 0,
        radius: 140
    }).addTo(map).on('click', function(e) { $('#Lake').modal('show');});

    function locLake() {
        map.setView([600, 100], 1);
    }


    var Tree = L.circle([750, 1200], {
        color: 'rgba(255,0,51,0)',
        fillColor: '#ff0033',
        fillOpacity: 0,
        radius: 100
    }).addTo(map).on('click', function(e) { $('#Tree').modal('show');});

    function locTree() {
        map.setView([750, 1200], 1);
    }

    var Moandoa = L.circle([1000, 350], {
        color: 'rgba(255,0,51,0)',
        fillColor: '#ff0033',
        fillOpacity: 0,
        radius: 120
    }).addTo(map).on('click', function(e) { $('#Moandoa').modal('show');});

    function locMoandoa() {
        map.setView([1000, 350], 1);
    }
</script>




<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
