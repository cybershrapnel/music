<?php
if (isset($_GET['song'])) {
    $songToPlay = htmlspecialchars(urldecode($_GET['song'])); // Decode the song name
    $isVideo = preg_match('/\.(mp4|webm|ogg)$/i', $songToPlay); // Check for video extensions
    $baseDirectory = $_SERVER['DOCUMENT_ROOT'] . ($isVideo ? "/video/" : "/music/mp3s/");

$backgroundImage = ''; // Default value for background image
$downloadUrl = ''; // Default value for download URL

    // Check if the song parameter starts with "http"
    $isHttpUrl = preg_match('/^https?:\/\//i', $songToPlay);

 // Function to validate file existence in the directory
    function findMediaFile($fileName, $directory) {
        $filePath = $directory . $fileName;


        return str_replace($_SERVER['DOCUMENT_ROOT'], "https://" . $_SERVER['HTTP_HOST'], $filePath);
    }

    //$baseDirectory = $_SERVER['DOCUMENT_ROOT'] . "/music/mp3s/"; // Absolute path to the MP3s directory
    $extensions = ["mp3"]; // Allowed file extensions
    $imageDirectory = $_SERVER['DOCUMENT_ROOT'] . "/eve_images/eve1/"; // Path to eve1 folder
    $imageExtensions = ["png", "jpg", "jpeg", "gif"]; // Allowed image extensions
    $swap=false;
$imageDir = isset($_GET['dir']) ? htmlspecialchars($_GET['dir'], ENT_QUOTES, 'UTF-8') : '';
$imageName = isset($_GET['image']) ? htmlspecialchars($_GET['image'], ENT_QUOTES, 'UTF-8') : '';
$imageBaseDirectory = $_SERVER['DOCUMENT_ROOT'] . "/eve_images/"; // Base directory for images
$imageExtensions = ["png", "jpg", "jpeg", "gif"]; // Allowed image extensions
$isEve =false;






    // Validate that songToPlay matches the UUID format
    $isValidUUID = preg_match(
        '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', 
        $songToPlay
    );
$UUID=false;
    if ($isValidUUID) {
       $UUID=true;
//$baseDirectory = "https://cdn1.suno.ai/";
    }




if (isset($_GET['eve'])) {
 $isEve =true;

    $baseDirectory = $_SERVER['DOCUMENT_ROOT'] . "/audio/"; // Absolute path to the MP3s directory
$extensions = ["mp3", "txt"]; // Allowed file extensions
}

function randomSong() {
    // Base directory for your MP3 files
 
if (isset($_GET['eve'])) {

    $baseDirectory = $_SERVER['DOCUMENT_ROOT'] . "/audio/"; // Absolute path to the MP3s directory
$extensions = ["mp3", "txt"]; // Allowed file extensions
}else{

$baseDirectory = $_SERVER['DOCUMENT_ROOT'] . '/music/mp3s/';
    $extensions = ['mp3']; // Allowed file extensions
}


    // Recursive function to gather all MP3 files
    function getFilesInDirectory($directory, $extensions) {
        $files = [];
        $items = scandir($directory);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $filePath = $directory . DIRECTORY_SEPARATOR . $item;
            if (is_dir($filePath)) {
                // Recursively fetch files in subdirectories
                $files = array_merge($files, getFilesInDirectory($filePath, $extensions));
            } else {
                // Check if the file has an allowed extension
                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                if (in_array(strtolower($fileExtension), $extensions)) {
                    $files[] = $filePath;
                }
            }
        }
        return $files;
    }

    // Get all MP3 files in the directory and subdirectories
    $allFiles = getFilesInDirectory($baseDirectory, $extensions);

    if (empty($allFiles)) {
        return null;
    }

    // Select a random file and return its filename without the extension
    $randomFile = $allFiles[array_rand($allFiles)];
    return pathinfo($randomFile, PATHINFO_FILENAME);
}





// Function to locate a specific image or fall back to a random image
function findImage($directory, $imageName, $baseDirectory, $extensions) {
    $fullDirectory = $baseDirectory . $directory . '/';

    // If specific image is requested
    if ($imageName && is_dir($fullDirectory)) {
        $imagePath = $fullDirectory . $imageName;
        if (is_file($imagePath)) {
            return str_replace($_SERVER['DOCUMENT_ROOT'], "https://" . $_SERVER['HTTP_HOST'], $imagePath);
        }
    }

    // Fall back to a random image if no specific image is found
    $files = scandir($fullDirectory);
    $imageFiles = array_filter($files, function($file) use ($fullDirectory, $extensions) {
        $filePath = $fullDirectory . $file;
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        return is_file($filePath) && in_array(strtolower($fileExtension), $extensions);
    });

    if (!empty($imageFiles)) {
        $randomImage = $imageFiles[array_rand($imageFiles)];
        return str_replace($_SERVER['DOCUMENT_ROOT'], "https://" . $_SERVER['HTTP_HOST'], $fullDirectory . $randomImage);
    }

    return false; // Return false if no image is found
}




if (!empty($imageName)) {
    $backgroundImage = findImage($imageDir, $imageName, $imageBaseDirectory, $imageExtensions);
} 

$random=false;

    if ($songToPlay === 'MEQSWAP') {
$songToPlay=htmlspecialchars(urldecode("Containment%20Sweat"));
$swap=true;
}
else if ($songToPlay === 'RANDOM') {
$songToPlay=randomSong();
$random=true;
}





    // Recursive function to find the MP3 file
    function findMp3InSubdirs($songName, $directory, $extensions) {
        $files = scandir($directory); // Get all files and folders in the directory
        foreach ($files as $file) {
            if ($file === "." || $file === "..") {
                continue; // Skip current and parent directory
            }
            $filePath = $directory . $file;

            if (is_dir($filePath)) {
                // If it's a directory, recursively search
                $result = findMp3InSubdirs($songName, $filePath . "/", $extensions);
                if ($result) {
                    return $result; // Return the file path if found
                }
            } else {
                // Check if the file matches the song name and extension
                foreach ($extensions as $ext) {
                    if (strcasecmp($file, $songName . "." . $ext) === 0) {
                        return $filePath; // Return the file path
                    }
                }
            }
        }
        return false; // Return false if not found in this directory
    }




    // Function to get a random image from a folder
    function getRandomImage($directory, $extensions) {
        if (!is_dir($directory)) {
            return false;
        }
        $files = scandir($directory);
        $imageFiles = array_filter($files, function($file) use ($directory, $extensions) {
            $filePath = $directory . $file;
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
            return is_file($filePath) && in_array(strtolower($fileExtension), $extensions);
        });

        if (empty($imageFiles)) {
            return false;
        }

        $randomFile = $imageFiles[array_rand($imageFiles)];
        return str_replace($_SERVER['DOCUMENT_ROOT'], "https://" . $_SERVER['HTTP_HOST'], $directory . $randomFile);
    }

    // Locate the MP3 file
    //$backgroundImage = getRandomImage($imageDirectory, $imageExtensions);



if (empty($backgroundImage)) {
$backgroundImage = getRandomImage($imageDirectory, $imageExtensions);
}

    // Locate the MP3 file
if (!$UUID){

//start
if ($isVideo){
$mp3Path = findMediaFile($songToPlay, $baseDirectory);
//echo " the old mp3path is: ".$mp3Path;
//$mp3Path= str_replace($_SERVER['DOCUMENT_ROOT'], "https://" . $_SERVER['HTTP_HOST'], $filePath);


}
else{
    $mp3Path = findMp3InSubdirs($songToPlay, $baseDirectory, $extensions);
}
//end

 }
else{
$mp3Path= "https://cdn1.suno.ai/" . $_GET['song'] . ".mp3";

}
    if ($isHttpUrl) {
        // If the song parameter is a URL, use it directly
        $mp3Path = $songToPlay;
        $mp3Url = $songToPlay;

    }
//echo "  the new mp3 path is: " . $mp3Path;
    if ($mp3Path) {
if (!$UUID){

$mp3Url = str_replace("'", "%27", str_replace($_SERVER['DOCUMENT_ROOT'], "https://" . $_SERVER['HTTP_HOST'], $mp3Path));
        $downloadUrl = "https://xtdevelopment.net/music/download/?author=NanoCheeZe&song=" . urlencode($songToPlay) . "&link=" . urlencode($mp3Url);
 if ($isHttpUrl) {
$downloadUrl=$mp3Url;
$downloadUrl = str_replace([' ', '%20'], '%2520', $downloadUrl);
$mp3Url=$downloadUrl;
}




}
else{

$mp3Url = $mp3Path;
$downloadUrl = "https://xtdevelopment.net/music/download/?author=Suno%20User&song=" . urlencode($songToPlay) . "&link=" . urlencode($mp3Url);

if (isset($_GET['title'])){
$downloadUrl = "https://xtdevelopment.net/music/download/?author=Suno%20User&song=" . urlencode($_GET['title']) . "&link=" . urlencode($mp3Url);
}

if (isset($_GET['artist'])) {
    $artist = urlencode($_GET['artist']);
    if (strpos($downloadUrl, "Suno%20User") !== false) {
        $downloadUrl = str_replace("Suno%20User", $artist, $downloadUrl);
    }
}





}



        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>";

    // Check if 'name' exists in the URL parameters
    $songtitle = isset($_GET['title']) ? $_GET['title'] : null;

    // If 'name' exists, use it as the title; otherwise, fall back to $songToPlay
    $title = $songtitle ? $songtitle : $songToPlay;

    echo "<title>" . htmlspecialchars($title) . "</title>";

if ($isVideo){
echo "
<script>
const isVideo = true;
</script>
";
}
else {
echo "
<script>
const isVideo = false;
</script>
";
}

          

if ($isEve){
echo "<script>
const isEve = true;
</script>";
}
else{
echo "<script>
const isEve = false;
</script>";
}


echo "

            <style>
               

        /* Hidden div for playlist */
#playlistDiv {
    display: none; /* Start hidden */
    position: relative;
    bottom: -10px;
    left: 0;
    width: 100%;
    height: 70%;
    background-color: rgba(0, 0, 0, 0.9);
    overflow-y: scroll; /* Enable scrolling */
    color: white;
max-width: 100%;
    z-index: 100000;
justify-self: center;

    /* Hide scrollbar for Chrome, Safari, and Edge */
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* Internet Explorer 10+ */
}

#playlistDiv::-webkit-scrollbar {
    display: none; /* Chrome, Safari, and Edge */
}
        #playlistDiv ul {
            list-style: none;
            padding: 0;
        }

        #playlistDiv li {
            padding: 10px;
            cursor: pointer;
            background-color: #333;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        #playlistDiv li:hover {
            background-color: #444;
        }


#toggle-playlist-btn {
    background-color: red;
    color: white;
    padding: 10px 15px;
    font-size: 14px;
    cursor: pointer;
    border: none;
    border-radius: 5px;
}

#toggle-playlist-btn:hover {
    background-color: darkred;
}

                iframe {
                    border: none;
                    width: 100%;
                    height: 100%;
                }

                   body {
font-family: Arial, sans-serif;
                    color: #fff;
                    padding: 0;
        margin: 0;
        overflow: hidden;
    }

    .background-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
    }

    .background-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
                    background-image: url('" . htmlspecialchars($backgroundImage) . "');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transform-origin: 50% calc(50% - 150px); /* Center horizontally, offset 100px upwards */
        animation: zoom-in-out 60s infinite ease-in-out; /* 60s for zoom-in and out */
    }

    @keyframes zoom-in-out {
        0%, 100% {
            transform: scale(1); /* Original size */
        }
        50% {
            transform: scale(1.5); /* Zoomed in by 10% */
        }
    }
                #popupCanvas {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                }
                .highlight {
                    background: rgba(0, 0, 0, 0.6);
                    padding: 10px 20px;
                    border-radius: 10px;
                    display: inline-block;
                    position: relative;
                    z-index: 100;
                }
                audio {
                    position: relative;
                    z-index: 100;
                }
    #song-title {
        background: rgba(0, 0, 0, 0.6);
        padding: 10px 20px;
        border-radius: 10px;
        display: inline-block;
        text-align: center;
        position: relative;
        z-index: 100;
        font-size: 1rem; /* Default font size */
        transition: font-size 0.3s ease; /* Smooth transition */
overflow-wrap: anywhere;
    }
#random-song-container {
    position: absolute; /* Matches the button's positioning context */
    padding: 10px; /* Adds space around the button */
    background-color: rgba(0, 0, 0, 0.5); /* Translucent background */
    border-radius: 5px; /* Smooth corners */
    z-index: 9999; /* Ensures it stays above other elements */
}

        #random-song-btn {
            
            bottom: 100px; /* Distance from the top */
            left: 10px; /* Distance from the left */
            background-color: #007bff; /* Blue button */
            color: white;
            border: none;
            padding: 5px 10px; /* Smaller button */
            font-size: 8px; /* Smaller font size */
            border-radius: 1px;
            cursor: pointer;
z-index: 5000;
        }
        #random-song-btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

/* Media Player Container */
#player {
    padding: 20px;
    background-color: #1e1e1e; /* Slate black to match the theme */
    color: white;
    border-radius: 10px; /* Rounded corners for a modern look */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    box-shadow: 0 0px 0px rgba(0, 0, 0, 0.5); /* Subtle shadow for depth */
}

/* Media Player (Audio Element) */
audio {
    width: 100%; /* Full width inside the container */
    background-color: #2c2c2c; /* Darker gray for controls */
    color: white; /* White text/icons */
    border: none; /* Remove borders */
    border-radius: 8px; /* Match container rounding */
    padding: 5px 0;
}

/* Custom styles for media controls */
audio::-webkit-media-controls-panel {
    background-color: #2c2c2c !important; /* Ensure dark controls */
    color: white !important; /* White text/icons */
}

audio::-webkit-media-controls-play-button,
audio::-webkit-media-controls-pause-button,
audio::-webkit-media-controls-mute-button {
    filter: invert(1); /* Inverts icons for light-on-dark effect */
}

audio::-webkit-media-controls-timeline {
    background-color: #2c2c2c; /* Subtle gray for the timeline */
}

audio::-webkit-media-controls-current-time-display,
audio::-webkit-media-controls-time-remaining-display {
    color: #ccc; /* Slightly lighter gray for text */
}

audio::-webkit-media-controls-volume-slider {
    background-color: #444;
    border-radius: 5px;
}

/* Hover and Focus Effects */
audio:hover, audio:focus {
    outline: none; /* Remove focus outline */
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.2); /* Glow effect */
}

/* Playlist Styling */
#playlistContent {
    padding: 15px;
    background-color: rgba(30, 30, 30, 0.9); /* Slight transparency */
    color: white;
    border-radius: 10px;
    overflow-y: auto; /* Enable scrolling if needed */
}

/* Playlist Item Styling */
#songList li {
    padding: 10px;
    cursor: pointer;
    color: white;
    background-color: #2c2c2c; /* Match player controls */
    margin-bottom: 5px;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

#songList li:hover {
    background-color: #444; /* Highlight on hover */
    color: #ffeb3b; /* Yellow text for hover */
}

/* Highlight the currently playing song */
#songList li.selected {
    background-color: #555; /* Distinct gray for selected */
    color: white;
    font-weight: bold;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    #player {
        padding: 10px;
        font-size: 14px;
    }

    audio {
        border-radius: 5px;
    }

    #songList li {
        padding: 8px;
    }
}

/* Scrollbar for Playlist */
#playlistContent::-webkit-scrollbar {
    width: 10px;
}
#playlistContent::-webkit-scrollbar-thumb {
    background: #555;
    border-radius: 5px;
}
#playlistContent::-webkit-scrollbar-track {
    background: #2c2c2c;
}

";


if ($swap) {
    echo "
    
        #popupCanvas {
            pointer-events: none; /* Make spinner div passive */
        }
    
    ";
}


echo "


            </style>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.4.0/p5.js'></script>
        </head>
        <body>

";

    // Check if the song is "MEQSWAP"
    if ($swap) {
        //echo "<iframe src='https://swap.nanocheeze.com'></iframe>";
            //echo "<iframe src='https://swap.nanocheeze.com' style='border: none; width: 100%; height: 100%; position: absolute; top: 0; left: 0;'></iframe>";
echo "
<div style='
    position: absolute; 
    top: 0; 
    left: 0; 
    width: 200%; 
    height: 200%; 
    transform: scale(0.25); /* Scale the iframe content */
    transform-origin: top left; /* Ensure scaling starts from the top left */
'>
    <iframe src='https://swap.nanocheeze.com' 
        style='
            border: none; 
            width: 200%; /* Double the width since the content is scaled down */
            height: 200%; /* Double the height for the same reason */
            position: absolute; 
            top: 0; 
            left: 0;
        '>
    </iframe>
</div>";

    }


echo "



<div id='random-song-container'>";


if (isset($_GET['playlist'])){
    echo "<button id='toggle-playlist-btn' style='background-color: red; color: white; padding: 10px 15px; font-size: 14px; cursor: pointer; margin-bottom: 10px;'>More</button><br/>";
}


   echo "<button id='random-song-btn' style='padding: 10px 15px; font-size: 14px; cursor: pointer;'>Next</button>
</div>";

echo "
<div id='textTitle' style='text-align: center;max-width: 75%;justify-self: center;'>";
if (isset($_GET['title'])){

            echo "<h1 id='song-title' style='background: rgba(0, 0, 0, 0.6); padding: 10px 20px; border-radius: 10px; display: inline-block; text-align: center; position: relative; z-index: 100;'>" . $_GET['title'] . "</h1>";
}
else{
echo "<h1 id='song-title' style='background: rgba(0, 0, 0, 0.6); padding: 10px 20px; border-radius: 10px; display: inline-block; text-align: center; position: relative; z-index: 100;'>" . htmlspecialchars($songToPlay) . "</h1>";
}
echo "</div>";



if (strpos($songToPlay, 'storage.googleapis.com/udio-artifacts') !== false) {
    echo "<a id='spinnerLink' target='_blank' href='https://www.udio.com'>";
} else if(!$UUID){
echo "<a id='spinnerLink' target='_blank' href='https://music.nanocheeze.com#" . htmlspecialchars(urlencode($songToPlay)) . "'>";
}
else{
echo "<a id='spinnerLink' target='_blank' href='https://suno.com/song/" . htmlspecialchars(urlencode($songToPlay)) . "'>";
}


echo "
<div id='popupCanvas' style='display: none; position: fixed; top: 80px; left: -250; width: 100%; height: 100%; z-index: 1000;'></div>
</a>
";



echo "

<div id='logo-container' style='position: fixed; top: 50%;left: 50%;transform: translate(-50%, -50%); z-index: 0;'>
<a id='logo-link' href='https://info.nanocheeze.com' target='_blank'>
                    <img id='logo' src='logo.png' alt='Logo' style='width: 100px; height: auto; z-index: 0;'>
                </a>
</div>
            <script>
    let analyser, dataArray, bufferLength, audioContext, logo;
    let particles = [];
    let hueIndex = 0;
    let hueChangeInterval = 20;
    let isSpinning = false;
    let rotationAngle = 0;
    let spinDirection = 1;
    let spinStartTime = 0;
    let spinDuration = 500;
    let peakThreshold = 100;
    let popupOpen = false;
    let level = 0;
    let setupComplete = false;




// Get the URL parameters
const urlParams = new URLSearchParams(window.location.search);
let imagePaths = [];
// Check if the 'icon' parameter exists and branch logic accordingly
if (urlParams.has('icon')) {
    const iconValue = urlParams.get('icon');
    
    // Check the value of the 'icon' parameter
    if (iconValue) {
        console.log(`Icon parameter exists with value: ${iconValue}`);
        // Add your logic here when 'icon' exists and has a value

iconURL='https://pbs.twimg.com/profile_images/'+iconValue;
imagePaths = [iconURL];
    } else {
        console.log('Icon parameter exists but has no value.');
        // Add your logic here when 'icon' exists but is empty
imagePaths = ['https://pbs.twimg.com/profile_images/1807517561598181376/tgNisKbX_400x400.jpg'];
    }
} else {
    console.log('Icon parameter does not exist.');
    // Add your logic here when 'icon' is not present
  // Variables for image cycling
    imagePaths = ['logo.png', 'logo2.png', 'logo.png', 'logo3.png', 'logou.png', 'logo4.png', 'logo.png', 'logo5.png', 'logo.png', 'ad.png']; // List of image paths
}




  



    let currentImageIndex = 0; // Index of the current image
    let lastImageChangeTime = 0; // Time of the last image change
    let imageChangeInterval = 45000; // 45–90 seconds (initial value)

    function preload() {
        logo = loadImage(imagePaths[currentImageIndex]); // Load the initial image
    }
let mediaElement;
    function setup() {
        const canvas = createCanvas(600, 400);
        canvas.parent('popupCanvas');
        canvas.style('background-color', 'transparent'); // Set canvas background to transparent
        document.querySelector('#popupCanvas canvas').style.position = 'absolute'; // Position it over the page
        colorMode(HSB, 360, 100, 100);
        noLoop(); // Stop animation by default

        // Setup audio analyzer only on first right-click
        document.getElementById('logo-link').addEventListener('contextmenu', initializePopup);

        lastImageChangeTime = millis(); // Set the initial time for image change
        imageChangeInterval = random(45000, 90000); // Randomize the first interval
if(isVideo){
    const popupCanvas = document.getElementById('popupCanvas');

popupCanvas.style.pointerEvents  = 'none';
const defaultCanvas = document.getElementById('defaultCanvas0');
defaultCanvas.style.position  = 'relative';
if (isInIframe()) {
defaultCanvas.style.top  = '-200px';


}
}


    }

    function initializePopup(event) {

if(isVideo){
const textTitle = document.getElementById('textTitle');
//textTitle.style.top = '-15%';
textTitle.style.position = 'relative';
}
        if (event && typeof event.preventDefault === 'function') {
            event.preventDefault();
        }
        const popup = document.getElementById('popupCanvas');

        if (typeof loop === 'function') {
            if (!popupOpen) {
                popup.style.display = 'block';
                if (!setupComplete) {
                    setupAudioAnalyzer(); // Run only once
                    setupComplete = true;
                }
                loop(); // Start animation
            } else {
                popup.style.display = 'none';
                noLoop(); // Stop animation
            }

            popupOpen = !popupOpen;
        } else {
            // p5 is not ready yet, so wait a bit and try again
            setTimeout(() => initializePopup(event), 100);
        }
    }

    function setupAudioAnalyzer() {
        // Set up Web Audio API

    // Check if video exists; otherwise, fall back to audio
    const videoElement = document.querySelector('video');
    const audioElement = document.getElementById('audio');
    mediaElement = videoElement || audioElement;

    if (!mediaElement) {
        console.error('Neither video nor audio element found!');
        return;
    }

        const audio = mediaElement; // Existing audio element
        audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const track = audioContext.createMediaElementSource(audio);

        // Create an analyser node
        analyser = audioContext.createAnalyser();
        analyser.fftSize = 256;
        bufferLength = analyser.frequencyBinCount;
        dataArray = new Uint8Array(bufferLength);

        // Connect the analyser to the audio context, then connect to the destination
        track.connect(analyser);
        analyser.connect(audioContext.destination);

        // Resume audio context if it’s not active
        if (audioContext.state === 'suspended') {
            audioContext.resume();
        }
    }
let didit=false;
    function draw() {
        clear(); // Clear the canvas to maintain transparency
        analyser.getByteFrequencyData(dataArray); // Get audio data
        level = getAverageVolume(dataArray);

        // Check if it's time to change the image
if(imagePaths.length>1){
        if (millis() - lastImageChangeTime > imageChangeInterval) {
            currentImageIndex = (currentImageIndex + 1) % imagePaths.length; // Cycle to the next image
            logo = loadImage(imagePaths[currentImageIndex]); // Load the new image
            lastImageChangeTime = millis(); // Update the last change time
            imageChangeInterval = random(45000, 90000); // Set the next interval
        }
}
else if (newLogo !== '') {
    loadImage(newLogo, (img) => {
        logo = img; // Assign the loaded image to the logo
        newLogo = '';
        didit = false; // Reset the mask application flag
    });
}




        if (frameCount % hueChangeInterval === 0) hueIndex = (hueIndex + 1) % 15;
        let currentHue = map(hueIndex, 0, 15, 0, 360);

        let scale = map(level, 0, 255, 100, 400);

        if (level > peakThreshold && !isSpinning) startSpin();
        if (isSpinning) updateSpin();


if(!didit){
didit=true;
    // Create a circular mask
    let maskGraphics = createGraphics(scale, scale);
    maskGraphics.ellipse(scale / 2, scale / 2, scale); // Draw a circle mask

    // Apply the mask to the logo
    let maskedLogo = logo.get(); // Clone the image
    maskedLogo.mask(maskGraphics);
logo = maskedLogo;
}


        // Draw the spinning logo
        push();
        translate(width / 2, height / 2);
        rotate(radians(rotationAngle));
        imageMode(CENTER);
        image(logo, 0, 0, scale, scale);
        pop();

        // Add particles
        //let numParticles = int(map(level, 0, 255, 0, 10));
let maxParticles = isVideo ? 3 : 10; // Reduce particles if video is playing
let numParticles = int(map(level, 0, 255, 0, maxParticles));


        for (let i = 0; i < numParticles; i++) particles.push(new Particle(width / 2, height / 2, currentHue));
        particles.forEach((p, i) => {
            p.update();
            p.display();
            if (p.isFinished()) particles.splice(i, 1);
        });
    }

    function startSpin() {
        isSpinning = true;
        spinStartTime = millis();
        rotationAngle = 0;
        spinDirection = random() > 0.5 ? 1 : -1;
    }

    function updateSpin() {
        let elapsedTime = millis() - spinStartTime;
        let spinProgress = map(elapsedTime, 0, spinDuration, 0, 360);
        rotationAngle = spinProgress * spinDirection;
        if (elapsedTime >= spinDuration) isSpinning = false;
    }

    class Particle {
        constructor(x, y, hue) {
            this.position = createVector(x, y);
            this.velocity = p5.Vector.random2D().mult(random(2, 5));
            this.lifespan = 255;
            this.hue = hue;
        }

        update() {
            this.position.add(this.velocity);
            this.lifespan -= 4;
        }

        display() {
            noStroke();
            fill(this.hue, 100, 100, this.lifespan / 255 * 100);
            ellipse(this.position.x, this.position.y, 8, 8);
        }

        isFinished() {
            return this.lifespan < 0;
        }
    }

    function getAverageVolume(array) {
        let values = 0;
        for (let i = 0; i < array.length; i++) values += array[i];
        return values / array.length;
    }
</script>
<div id='parent-container'>
<div id='audio-container' style='position: absolute; bottom: 10px; width: 100%; display: flex; justify-content: center; z-index: 2000;'>
                ";//end echo
if ($isVideo) {
//echo "mp3 url shoud be here";


if (isset($_GET['loop'])) {
echo "<video controls autoplay loop>";
}
else{
echo "<video controls autoplay>";
}


echo "
                <source id='video-source' src='" . htmlspecialchars($mp3Url) . "' type='video/mp4'>
                Your browser does not support the video tag.
            </video>

";
}
else{
echo "
<audio id='audio' controls autoplay loop style='position: fixed; bottom: 10px; width: 98%; display: flex; justify-content: center; z-index: 2000;'>

                <source id='audio-source' src='" . htmlspecialchars($mp3Url) . "' type='audio/mpeg'>
                Your browser does not support the audio element.
            </audio>
";

}

echo "


            </div></div>


<div id='animationPopup' style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;'>


    <canvas id='popupCanvas'></canvas>
</div>


<script>
// Function to check if the page is inside an iframe
function isInIframe() {
    try {
        return window.self !== window.top; // If window.self is not window.top, we're in an iframe
    } catch (e) {
        return true; // Catch and assume it's in an iframe if an error occurs
    }
}
setTimeout(() => {
    //document.addEventListener('DOMContentLoaded', () => {
        // Function to check if the audio is playing
        function waitForAudioToPlay() {
    const videoElement = document.querySelector('video');
    const audioElement = document.getElementById('audio');
    mediaElement = videoElement || audioElement;
console.log('it is this: ' + mediaElement);

            const audio = mediaElement; // Your audio element
            const logoLink = document.getElementById('logo-link');
            const logoContainer = document.getElementById('logo-container');

            if (!audio) {
                console.error('Audio element not found!');
                return;
            }

            const checkAudio = setInterval(() => {
                if (!audio.paused) {
                    // If the audio is playing
                    clearInterval(checkAudio); // Stop checking

                    if (logoLink) {
                        const event = new MouseEvent('contextmenu', {
                            bubbles: true, // Ensures the event bubbles up the DOM
                            cancelable: true, // Allows the event to be canceled
                            view: window, // Specifies the window object as the event view
                        });



if (isInIframe()) {

    // Directly dispatch the event if inside an iframe
    setTimeout(() => {



        logoLink.dispatchEvent(event); // Dispatch the event
        if (logoContainer) {
            logoContainer.style.display = 'none'; // Make the container invisible
        }


    }, 2000); // 2000 milliseconds = 2 seconds script crashes if it happens too fast



} else {


    // Add a 15-second timeout if not inside an iframe
    setTimeout(() => {



        logoLink.dispatchEvent(event); // Dispatch the event
        if (logoContainer) {
            logoContainer.style.display = 'none'; // Make the container invisible
        }


    }, 2000); // 2000 milliseconds = 2 seconds script crashes if it happens too fast



}


                    }
                }
            }, 500); // Check every 500ms
        }

        // Wait 2 seconds, then start checking
        setTimeout(() => {
            waitForAudioToPlay();
        }, 2000); // 2 seconds delay
    //});

}, 2000);

</script>


        ";
    } else {
        //echo "<h1>File Not Found</h1>";
    }
}
?>
    <script>
      const directoryURL = 'https://xtdevelopment.net/music/mp3s/lyrical/';
const imageDirectoryURL = 'https://xtdevelopment.net/eve_images/eve1/';
const imageExtensions = ['png', 'jpg', 'jpeg', 'gif'];



// List of directories to choose from
const songDirectories = [
    'https://xtdevelopment.net/music/mp3s/lyrical/',
    'https://xtdevelopment.net/music/mp3s/lyrical/berry/',
    'https://xtdevelopment.net/music/mp3s/lyrical/new/',
    'https://xtdevelopment.net/music/mp3s/lyrical/november/',
    'https://xtdevelopment.net/music/mp3s/new/',
    'https://xtdevelopment.net/music/mp3s/new/loveagain/',
    'https://xtdevelopment.net/music/mp3s/instrumental/',
    'https://xtdevelopment.net/music/mp3s/instrumental/darksynth_september/',
    'https://xtdevelopment.net/music/mp3s/instrumental/strawberry_darksynth/',
    'https://xtdevelopment.net/music/mp3s/instrumental/synth_november/',
    'https://xtdevelopment.net/music/mp3s/instrumental/synthbignov/',
    'https://xtdevelopment.net/music/mp3s/lyrical/bignov/'
];

const imageDirectories = [
    'https://xtdevelopment.net/eve_images/eve1/',
    'https://xtdevelopment.net/eve_images/eve2/',
    'https://xtdevelopment.net/eve_images/eve3/',
    'https://xtdevelopment.net/eve_images/eve4/',
    'https://xtdevelopment.net/eve_images/eve5/',
    'https://xtdevelopment.net/eve_images/eve6/',
    'https://xtdevelopment.net/eve_images/eve7/',
    'https://xtdevelopment.net/eve_images/eve8/',
    'https://xtdevelopment.net/eve_images/eve9/',
    'https://xtdevelopment.net/eve_images/eve10/',
    'https://xtdevelopment.net/eve_images/eve11/',
    'https://xtdevelopment.net/eve_images/eve12/',
    'https://xtdevelopment.net/eve_images/eve13/',
    'https://xtdevelopment.net/eve_images/eve14/',
    'https://xtdevelopment.net/eve_images/eve15/',
    'https://xtdevelopment.net/eve_images/ai1/',
    'https://xtdevelopment.net/eve_images/ai2/',
    'https://xtdevelopment.net/eve_images/ai3/',
    'https://xtdevelopment.net/eve_images/ai4/',
    'https://xtdevelopment.net/eve_images/ai5/',
    'https://xtdevelopment.net/eve_images/ai6/',
    'https://xtdevelopment.net/eve_images/ai7/',
    'https://xtdevelopment.net/eve_images/ai8/',
    'https://xtdevelopment.net/eve_images/eve16/'
];
// Function to pick a random directory from a list
function getRandomDirectory(directories) {
    return directories[Math.floor(Math.random() * directories.length)];
}
// Function to fetch and load a random song
function loadRandomSong() {
    let directoryURL;
    if (isEve) {
        directoryURL = 'https://xtdevelopment.net/audio/'; // Audio directory
    } else if (isVideo) {
        directoryURL = 'https://xtdevelopment.net/video/'; // Video directory
    } else {
        directoryURL = getRandomDirectory(songDirectories); // Random directory
    }
let FixdirectoryURL = directoryURL;
if(isVideo){
FixdirectoryURL = directoryURL +'indexN.php';
}
    fetch(FixdirectoryURL)
        .then((response) => response.text())
        .then((html) => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // Decide file extension based on media type
            const fileExtension = isVideo ? '.mp4' : '.mp3';

            // Filter files by the correct extension
            const links = Array.from(doc.querySelectorAll('a'))
                .map((link) => link.getAttribute('href'))
                .filter((href) => href && href.endsWith(fileExtension));

            if (links.length > 0) {
                const randomFile = links[Math.floor(Math.random() * links.length)];
                const mediaName = randomFile.replace(fileExtension, ''); // Remove extension
                let mediaUrl = directoryURL + encodeURIComponent(randomFile); // Full URL
                let downloadUrl = mediaUrl;
                console.log(`Selected URL: ${mediaUrl}`);
                if (isVideo) {
                    mediaUrl = mediaUrl.replace('/video/', '/video/');
console.log(`New Selected URL: ${mediaUrl}`);

                }




                // Select appropriate media element based on isVideo
                const mediaElement = isVideo
                    ? document.querySelector('video')
                    : document.getElementById('audio');

                if (!mediaElement) {
                    console.error('Media element not found! Check if it exists on the page.');
                    return;
                }

                // Check for existing source or create a new one
                let mediaSource;
                if (isVideo) {
                    // For video, check for an existing <source> or create one
                    mediaSource = mediaElement.querySelector('source') || document.createElement('source');
                    mediaSource.type = 'video/mp4';
                } else {
                    // For audio, create or use existing logic
                    mediaSource = document.getElementById('audio-source');
                    if (!mediaSource) {
                        mediaSource = document.createElement('source');
                        mediaSource.id = 'audio-source';
                        mediaSource.type = 'audio/mpeg';
                        mediaElement.appendChild(mediaSource);
                    }
                }

                // Update the source and start playback
                mediaSource.src = mediaUrl;
               if (isVideo){
let videoElementSource = document.getElementById('video-source');
videoElementSource = mediaUrl;
const videoElement = document.querySelector('video');
videoElement.src=mediaUrl;

}



                    mediaElement.appendChild(mediaSource);
               
if(!isVideo){
              mediaElement.src = mediaUrl;
}
                mediaElement.load();
                mediaElement.play();

                // Update song/video title
                const songTitleElement = document.getElementById('song-title');
                if (songTitleElement) songTitleElement.textContent = mediaName;

                // Update spinner link dynamically
                const spinnerLink = document.querySelector("a[href*='https://music.nanocheeze.com']");
                if (spinnerLink) spinnerLink.href = `https://music.nanocheeze.com#${encodeURIComponent(mediaName)}`;

                // Update download link dynamically
                const downloadLink = document.getElementById('download-link');
                if (downloadLink) {
                    downloadLink.href = `https://xtdevelopment.net/music/download/?author=NanoCheeZe&song=${encodeURIComponent(mediaName)}&link=${encodeURIComponent(downloadUrl)}`;
                }

                // Load a new random background image
                loadRandomImage();
            } else {
                alert(`No ${isVideo ? 'video' : 'audio'} files found in the directory.`);
            }
        })
        .catch((error) => console.error('Error fetching directory listing:', error));
}



// Function to fetch and set a random image as the background
function loadRandomImage() {
    const directoryURL = getRandomDirectory(imageDirectories); // Pick a random image directory

    // Disable the button initially
    const button = document.getElementById('random-song-btn');
    button.disabled = true;
    button.style.cursor = 'not-allowed';
    button.style.opacity = '0.6'; // Dim the button for visual feedback

    fetch(directoryURL)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const imageLinks = Array.from(doc.querySelectorAll('a'))
                .map(link => link.getAttribute('href'))
                .filter(href => {
                    const extension = href.split('.').pop().toLowerCase();
                    return imageExtensions.includes(extension);
                });

            if (imageLinks.length > 0) {
                const randomImage = imageLinks[Math.floor(Math.random() * imageLinks.length)];
                const backgroundImageUrl = directoryURL + randomImage;

                // Preload the image to ensure it is fully loaded
                const img = new Image();
                img.onload = () => {
                    // Update the background image
                    let styleElement = document.getElementById('dynamic-background-style');
                    if (!styleElement) {
                        styleElement = document.createElement('style');
                        styleElement.id = 'dynamic-background-style';
                        document.head.appendChild(styleElement);
                    }

                    styleElement.innerHTML = `
                        .background-container::before {
                            content: "";
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background-image: url('${backgroundImageUrl}');
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            transform-origin: 50% calc(50% - 100px);
                            animation: zoom-in-out 60s infinite ease-in-out;
                        }
                    `;

                    // Re-enable the button
                    button.disabled = false;
                    button.style.cursor = 'pointer';
                    button.style.opacity = '1'; // Restore button opacity
                };

                // Handle error loading the image
                img.onerror = () => {
                    console.error('Failed to load image:', backgroundImageUrl);
                    button.disabled = false;
                    button.style.cursor = 'pointer';
                    button.style.opacity = '1'; // Restore button opacity
                };

                // Set the image source to start loading
                img.src = backgroundImageUrl;
            } else {
                console.error('No images found in the directory.');
                button.disabled = false;
                button.style.cursor = 'pointer';
                button.style.opacity = '1'; // Restore button opacity
            }
        })
        .catch(error => {
            console.error('Error fetching image directory:', error);
            button.disabled = false;
            button.style.cursor = 'pointer';
            button.style.opacity = '1'; // Restore button opacity
        });
}

// Attach event listener to the button

<?php 

if (!isset($_GET['playlist'])){

       echo "document.getElementById('random-song-btn').addEventListener('click', loadRandomSong);";
}
?>



    </script>

<script>
    // Function to adjust font size based on viewport height
    function adjustFontSize() {
        const songTitle = document.getElementById('song-title');

        if (!songTitle) return;

        const viewportHeight = window.innerHeight;
        if (viewportHeight < 400) {
            songTitle.style.fontSize = '0.5rem'; // Smaller font size

        } 
else if (viewportHeight < 1000) {
            songTitle.style.fontSize = '1rem'; // Smaller font size
        } 
else {
            songTitle.style.fontSize = '2rem'; // Default font size

        }
    }

    // Initial adjustment
    adjustFontSize();

    // Add event listener for resizing the window
    window.addEventListener('resize', adjustFontSize);

document.addEventListener('DOMContentLoaded', () => {
    // Add event listeners to the song title div
    const songTitle = document.getElementById('song-title');
    if (songTitle) {
    songTitle.addEventListener('click', (event) => {
        initializePopup(event); // Keep the existing popup functionality

        // Hide the playlist menu
        const playlistDiv = document.getElementById('playlistDiv');
        if (playlistDiv && playlistDiv.style.display !== 'none') {
            playlistDiv.style.display = 'none';
            console.log("Playlist menu hidden after song-title click.");
        }
    });

    songTitle.addEventListener('contextmenu', (event) => {
        initializePopup(event); // Keep the existing popup functionality

        // Hide the playlist menu
        const playlistDiv = document.getElementById('playlistDiv');
        if (playlistDiv && playlistDiv.style.display !== 'none') {
            playlistDiv.style.display = 'none';
            console.log("Playlist menu hidden after song-title right-click.");
        }
    });

    }
});

document.addEventListener('DOMContentLoaded', () => {
    // Identify the media element based on isVideo
    const mediaElement = isVideo ? document.querySelector('video') : document.getElementById('audio');
    const nextButton = document.getElementById('random-song-btn');

    if (!mediaElement || !nextButton) {
        console.error('Media element or next button not found.');
        return;
    }

    // Add an event listener to detect the end of playback
    mediaElement.addEventListener('ended', () => {
        console.log(`${isVideo ? 'Video' : 'Audio'} ended. Proceeding to the next track...`);
        nextButton.click(); // Trigger the next button
    });

    // Additional setup for the next button
    nextButton.addEventListener('click', () => {
        // Ensure loop mode is disabled
        mediaElement.loop = false;

        // Remove and re-add the listener to avoid duplicates
        mediaElement.removeEventListener('ended', handleTrackEnd);
        mediaElement.addEventListener('ended', handleTrackEnd);
    });

    // Handle track end by simulating a click on the next button
    function handleTrackEnd() {
        console.log(`${isVideo ? 'Video' : 'Audio'} playback ended.`);
        nextButton.click();
    }
});


document.addEventListener('DOMContentLoaded', () => {
    const audioPlayer = document.getElementById('audio');

    function attemptPlayback(retryCount = 0) {
        if (retryCount > 10) { // Limit retries to prevent infinite loop
            console.error('Maximum retry attempts reached. Autoplay failed.');
            return;
        }

setTimeout(() => {
    // Check if the audio is not already playing
    if (audioPlayer.paused) {
        audioPlayer.play()
            .then(() => {
                console.log('Audio autoplay started successfully.');
            })
            .catch((error) => {
                console.error('Error starting autoplay:', error);
                if (error.name === 'NotAllowedError') {
                    console.log(`Retrying playback in 2 seconds... Attempt #${retryCount + 1}`);
                    attemptPlayback(retryCount + 1); // Retry playback
                }
            });
    } else {
        console.log('Audio is already playing, skipping .play() call.');
    }
}, 2000); // Wait 2 seconds

    }

    // Start the first playback attempt
    attemptPlayback();
});


</script>
<script>
    // Listener for page load
    document.addEventListener('DOMContentLoaded', () => {
        // Get the audio element
        const audioElement = document.getElementById('audio');

        if (audioElement) {
            // Remove the background color from the audio element itself
            audioElement.style.backgroundColor = 'unset';

            console.log('Audio element background color reset.');
        }
    });
</script>



<?php
if (!$swap) {
    echo "
        <style>
            /* Reset and ensure full-page coverage */
            html, body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                overflow: hidden; /* Prevent scrollbars */
            }

            #canvas {
                position: absolute; /* Ensure it spans the entire viewport */
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: block; /* Avoid inline spacing issues */
            }
        </style>

        <canvas id='canvas'></canvas>
        <script>
            // Floating Bubbles Effect
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');

            // Dynamically resize canvas to match the viewport
            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }

            // Adjust canvas size on load and window resize
            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            const imageSources = ['https://info.nanocheeze.com/images/ncz.png', 'https://swap.nanocheeze.com/gold.png', 'https://swap.nanocheeze.com/red.png', 'https://swap.nanocheeze.com/blue.png', 'https://swap.nanocheeze.com/green.png', 'https://swap.nanocheeze.com/flip.png']; 

// Get the URL parameters
const urlParams2 = new URLSearchParams(window.location.search);

// Check if the 'icon' parameter exists
if (urlParams2.has('icon')) {
    const iconValue = urlParams2.get('icon'); // Optional: get the value of the 'icon' parameter

    imageSources.push('https://pbs.twimg.com/profile_images/' + iconValue);

}


            let images = [];

            function createImages() {
                const numOfImages = Math.floor(Math.random() * 25) + 10;

                for (let i = 0; i < numOfImages; i++) {
                    const imgSrc = imageSources[Math.floor(Math.random() * imageSources.length)];
                    const img = {
                        image: new Image(),
                        x: (Math.random() < 0.5 ? -100 : canvas.width + 100),
                        y: (Math.random() < 0.5 ? -100 : canvas.height + 100),
                        speedX: (Math.random() - 0.5) * 2,
                        speedY: (Math.random() - 0.5) * 2,
                        scale: Math.random() * 0.35 + 0.1
                    };
                    img.image.src = imgSrc;
                    images.push(img);
                }
            }

        function updateAndDraw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas

    images.forEach(img => {
        img.x += img.speedX;
        img.y += img.speedY;

        // Reset positions if the image moves out of bounds
        if (img.x < -200 || img.x > canvas.width + 200 || img.y < -200 || img.y > canvas.height + 200) {
            img.x = (Math.random() < 0.5 ? -100 : canvas.width + 100);
            img.y = (Math.random() < 0.5 ? -100 : canvas.height + 100);
            img.speedX = (Math.random() - 0.5) * 5;
            img.speedY = (Math.random() - 0.5) * 5;
        }

        // Save the context state
        ctx.save();

        // Draw circular clipping path
        const radius = (img.image.width * img.scale) / 2; // Calculate radius based on image size and scale
        ctx.beginPath();
        ctx.arc(img.x, img.y, radius, 0, Math.PI * 2); // Draw a circle at the image's position
        ctx.clip(); // Apply the clipping mask

        // Draw the image inside the circular mask
        ctx.drawImage(
            img.image,
            img.x - radius, // Center the image inside the circle
            img.y - radius,
            img.image.width * img.scale, // Scale the image
            img.image.height * img.scale
        );

        // Restore the context state
        ctx.restore();
    });

    requestAnimationFrame(updateAndDraw); // Continue animation
}


            createImages();
            updateAndDraw();

 


        </script>";

if ($UUID) {
    echo "<script>
        const isUUID = true;
        const mp3Url = '" . htmlspecialchars($mp3Url) . "';
    </script>";
} else {
    echo "<script>
        const isUUID = false;
    </script>";
}

echo "
<div id='footer'>
Tap title bar to toggle Visualizer or here to toggle bubbles. 
</div>";






}
?>


<script>
let newLogo='';
       const footerDiv = document.getElementById('footer');

          if (footerDiv) {
    footerDiv.style.position = 'fixed'; // Fix to the viewport
    footerDiv.style.bottom = '0'; // Stick to the bottom
    footerDiv.style.width = '100%'; // Stretch to full width
    footerDiv.style.textAlign = 'center'; // Center-align the text
    footerDiv.style.backgroundColor = 'rgba(0, 0, 0, 0.7)'; // Optional: Add background color
    footerDiv.style.padding = '0px'; // Add padding
footerDiv.style.fontSize = '0.5rem';
footerDiv.style.zIndex = '10000';
footerDiv.addEventListener('click', () => {

    if (canvas.style.display === 'none') {
        canvas.style.display = 'block'; // Show the canvas
    } else {
        canvas.style.display = 'none'; // Hide the canvas
    }
});

}

        
let clickState = 0; // Ensure clickState starts at 0

document.getElementById('footer').addEventListener('click', () => {
    console.log("Before switch, clickState =", clickState); // Debug log to verify starting state

    switch (clickState) {
        case 0: // Step 1: Hide only the bubbles
            canvas.style.display = 'none'; // Hide bubbles
            console.log('Hiding bubbles');
            break;

        case 1: // Step 2: Hide elements and keep bubbles hidden
            document.getElementById('song-title').style.display = 'none';
            document.getElementById('audio-container').style.display = 'none';
            document.getElementById('download-container').style.display = 'none';
            document.getElementById('author').style.display = 'none';
            document.getElementById('random-song-container').style.display = 'none';
            console.log('Hiding elements');
canvas.style.display = 'none';
            break;

        case 2: // Step 3: Show bubbles, elements remain hidden
            canvas.style.display = 'block'; // Show bubbles
            console.log('Showing bubbles');
            break;

        case 3: // Step 4: Show elements, bubbles remain visible
            document.getElementById('song-title').style.display = 'block';
            document.getElementById('audio-container').style.display = 'block';
            document.getElementById('download-container').style.display = 'block';
            document.getElementById('author').style.display = 'block';
            document.getElementById('random-song-container').style.display = 'block';
            console.log('Showing elements');
canvas.style.display = 'block';
            break;

        default:
            console.error('Unexpected state:', clickState);
    }

    // Move to the next state
    clickState = (clickState + 1) % 4;
    console.log("After switch, clickState =", clickState); // Debug log to confirm next state
});


let changedBlob=false;
document.addEventListener('DOMContentLoaded', () => {
<?php
echo "const isHttpUrl = " . ($isHttpUrl ? 'true' : 'false') . ";";
echo "let mp3Url = " . json_encode($mp3Url) . ";";
?>

    if (isUUID) {
        const audioElement = document.getElementById('audio');
        console.log('We are a uuid or http');
console.log(mp3Url);
        // Fetch the MP3 file as a blob
        fetch(mp3Url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.blob();
            })
            .then(blob => {
                // Create a blob URL
                const blobUrl = URL.createObjectURL(blob);

                // Set the blob URL as the audio source
                audioElement.src = blobUrl;

                // Play the audio
                audioElement.play().catch(error => {
                    console.error('Error playing the audio:', error);
isUUID=false;
                });



setTimeout(() => {
            changedBlob=true;
        }, 2000);


            })
            .catch(error => {
                console.error('Error fetching the MP3 file:', error);
            });
    }
else if (isHttpUrl) {
    fetch('https://rpc.nanocheeze.com:8111/serve-mp3?url='+mp3Url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.blob();
        })
        .then(blob => {
            // Create a temporary anchor element
            const link = document.createElement('a');
            const objectUrl = URL.createObjectURL(blob);

            // Set the download attribute and href
            link.href = objectUrl;
            link.download = mp3Url.split('/').pop() || 'downloaded-file.mp3'; // Use the file name from the URL or a default name



// Dynamically update the download URL
const downloadLink = document.getElementById('download-link');
if (downloadLink) {
    // Get parameters from the URL
    const urlParams = new URLSearchParams(window.location.search);
    let artist = urlParams.get('artist') || '';
    //artist = artist ? artist + ' - ' : ''; // Add " - " only if artist exists
    const title = urlParams.get('title') || 'Unknown Title';

    // Format the filename as "Artist - Title.mp3" or just "Title.mp3" if no artist
    const fileName = `${artist}${title}.mp3`;

const baseDownloadUrl = 'https://xtdevelopment.net/music/download/';
const rpcProxyUrl = 'https://rpc.nanocheeze.com:8111/serve-mp3?url=';

// Build the RPC URL for the file without extra encoding
const rpcUrl = `${rpcProxyUrl}${mp3Url}`;

// Build the full xtdevelopment.net URL with the RPC as the `url` parameter
const newDownloadUrl = `${baseDownloadUrl}?author=${encodeURIComponent(artist.trim())}&song=${encodeURIComponent(title)}&link=${encodeURIComponent(rpcUrl)}`;

// Set the download link
const downloadLink = document.getElementById('download-link');
if (downloadLink) {
    downloadLink.href = newDownloadUrl;
    console.log(`Download URL set to: ${newDownloadUrl}`);
}

    console.log(`Download link updated: ${newDownloadUrl}`);
} else {
    console.error('Download link element not found.');
}



/*
//this will let you download the blob straight from browser, tested works have not enabled yet
needs to be swapped out in several place, will do later, maybe
                       // Dynamically update the download URL and enforce download
            const downloadLink = document.getElementById('download-link');
            if (downloadLink) {
                // Get parameters from the URL
                const urlParams = new URLSearchParams(window.location.search);
                let artist = urlParams.get('artist') || '';
                artist = artist ? artist + ' - ' : ''; // Add " - " only if artist exists
                const title = urlParams.get('title') || 'Unknown Title';

                // Format the filename as "Artist - Title.mp3" or just "Title.mp3" if no artist
                const fileName = `${artist}${title}.mp3`;

                // Update the download link
                downloadLink.href = objectUrl;
                downloadLink.setAttribute('download', fileName);

                console.log(`Download link updated to force download: ${objectUrl}`);
                console.log(`File will be downloaded as: ${fileName}`);
            } else {
                console.error('Download link element not found.');
            }

         

*/
            console.log('File downloaded successfully as a blob');

        const audioElement = document.getElementById('audio');

let videoElementSource = document.getElementById('video-source');
    const videoElement = document.querySelector('video');

if (videoElement) {
    console.log('This is a video!');

    // Stop the current playback and reset the video
    videoElement.pause();
    videoElement.currentTime = 0;

    // Set the new source and play
    videoElement.src = objectUrl;
videoElementSource = objectUrl;
    videoElement.load(); // Ensures the video is ready to play
    videoElement.play().catch(error => {
        console.error('Error playing the video:', error);
    });


}else{
console.log('This is a Audio!');
                // Set the blob URL as the audio source
                audioElement.src = objectUrl;
}
                // Play the audio

        })
        .catch(error => {
            console.error('Error downloading the file as a blob:', error);
        });
}

});



//new listner to overide the old one for suno playlists only this gets confusing 
//but this whole event listener can be removed to disbale suno
document.addEventListener('DOMContentLoaded', () => {
    const urlParamsLoad = new URLSearchParams(window.location.search);

 if (urlParamsLoad.has('playlist')) {



    const nextButton = document.getElementById('random-song-btn');
    const audioPlayer = document.getElementById('audio');
    const authorDiv = document.getElementById('author'); // Get the author div

    const urlParams = new URLSearchParams(window.location.search);
    const playlistFile = urlParams.get('playlist');
    let playlist = [];

    if (playlistFile) {
        fetch(playlistFile)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load playlist');
                }
                return response.json();
            })
            .then(data => {
                playlist = data;
UserPlaylist=playlist;

                if (playlist.length > 0) {
                    //loadRandomSong();
                    //play first song or not


            console.log('Playlist loaded successfully.');





//this update the spinner for the first song if its external url


setTimeout(() => {
    // Get the initial song UUID (update this with your actual logic for the initial song)
    const currentSongUUID = location.search.split('song=')[1]?.split('&')[0] || '';

    // Search for the current song in the playlist
    const matchedSong = playlist.find(song => song.uuid === currentSongUUID);

    // If a match is found, update the spinner link
    if (matchedSong && matchedSong.user) {
        const spinnerLink = document.getElementById('spinnerLink');
        if (spinnerLink) {
            const newLink = `https://www.udio.com/songs/${encodeURIComponent(matchedSong.user)}`;
            spinnerLink.href = newLink;
            console.log(`Spinner link updated to: ${newLink}`);
        } else {
            console.error('Spinner link element not found.');
        }
    } else {
        console.log('No matching song found in the playlist for UUID:', currentSongUUID);
    }
}, 5000); // 5 seconds delay

//update the spinner end










// Update author name
if (authorDiv) {
    // Check if the page is in an iframe
    if (window.self !== window.top) {
        // Get the current URL's query string (everything after the ?)
        const urlParams = window.location.search;

        // Construct the new URL by appending the current query string
        const embedUrl = `https://xtdevelopment.net/embed/player/${urlParams}`;

        // Set the innerHTML with the dynamically generated URL for iframe context
        authorDiv.innerHTML = `
            <a href="${embedUrl}" target="_blank" style="color: inherit; text-decoration: underline;">
                View outside of X
            </a>
            <br/>Push Next to start the playlist
        `;
    } else {
        // Set the innerHTML with the main site link for non-iframe context
        authorDiv.innerHTML = `
            <a href="https://music.nanocheeze.com" target="_blank" style="color: inherit; text-decoration: underline;">
                Visit music.nanocheeze.com
            </a>
            <br/>Push Next to start the playlist
        `;
    }
}
     


                }

                nextButton.addEventListener('click', handleNextClick);
            })
            .catch(error => {
                console.error('Error loading playlist:', error);
            });
    } else {
        nextButton.addEventListener('click', loadRandomSong);
    }

function handleNextClick() {
    if (playlist.length === 0) {
        console.warn('Playlist is empty. Reloading...');

        // Reload the playlist
        fetch(playlistFile)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to reload playlist');
                }
                return response.json();
            })
            .then(data => {
                playlist = data;

                if (playlist.length > 0) {
                    console.log('Playlist reloaded successfully. Playing the first song.');
                    loadRandomSong(); // Start playing the first song
                } else {
                    console.error('Reloaded playlist is still empty.');
                    alert('No songs available in the playlist.');
                }
            })
            .catch(error => {
                console.error('Error reloading playlist:', error);
                alert('Failed to reload playlist.');
            });
    } else {
        loadRandomSong();
    }
}



// Function to set the background image
function setBackgroundImage(imageUrl) {
    const styleElement = document.getElementById('dynamic-background-style') || document.createElement('style');
    styleElement.id = 'dynamic-background-style';
    styleElement.innerHTML = `
        .background-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('${imageUrl}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transform-origin: 50% calc(50% - 100px);
            animation: zoom-in-out 60s infinite ease-in-out;
        }
    `;
    document.head.appendChild(styleElement);
}

    let spinnerImage = document.getElementById('logo'); // Spinner element's image

    function swapSpinnerImage(profileUrl) {
        if (spinnerImage && profileUrl) {
            console.log(`Swapping spinner image to profile picture: ${profileUrl}`);
            //spinnerImage.src = profileUrl;
newLogo=profileUrl;
        } else {
            console.warn('Spinner image or profile URL is missing.');
        }
    }


    function loadRandomSong() {
        if (playlist.length === 0) {
            console.error('No more songs available.');
            return;
        }

        // Pick a random index
        const randomIndex = Math.floor(Math.random() * playlist.length);
        const song = playlist[randomIndex];

        if (!song || !song.uuid) {
            console.error('Invalid song in playlist:', song);
            return;
        }

        // Remove the song from the playlist
        playlist.splice(randomIndex, 1);

    // Check if the song's uuid is actually a full URL (starts with http/https)
    let songUrl;
    if (/^https?:\/\//.test(song.uuid)) {
        // Use the full URL as is
        songUrl = 'https://rpc.nanocheeze.com:8111/serve-mp3?url='+song.uuid;
    } else {
        // Otherwise, default to constructing the Suno CDN URL
        songUrl = `https://cdn1.suno.ai/${song.uuid}.mp3`;
    }

        const songIsHttp = songUrl.startsWith('http');

    const proxyPopup = document.getElementById("proxying-popup");

        if (songIsHttp) {
            // Show the proxying popup
            proxyPopup.style.display = 'block';
        }


    const downloadPageUrl = `https://xtdevelopment.net/music/download/`;
        const profileUrl = song.profile || ''; // Use the profile URL if available

        disableNextButton();
        fetch(songUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch song');
                }
                return response.blob();
            })
            .then(blob => {
                const blobUrl = URL.createObjectURL(blob);
                audioPlayer.src = blobUrl;
                audioPlayer.play();

                // Swap the spinner image if the profile picture is available
                       // Use the existing `swapSpinnerImage` function
                        if (songUrl.startsWith('http')) {
                            console.log('Udio song');
                        }else{



                if (profileUrl) {
                    swapSpinnerImage(profileUrl);
                }
               }



                const songTitleElement = document.getElementById('song-title');
                if (songTitleElement) {
                    songTitleElement.textContent = song.title || 'Unknown Title';
                }

// Update author name
if (authorDiv) {
    if (song.uuid.includes('storage.googleapis.com/udio-artifacts') && song.user) {
        // Handle Udio-specific songs
        authorDiv.innerHTML = `Creator: <a href="https://www.udio.com/songs/${encodeURIComponent(song.user)}" target="_blank" style="color: inherit; text-decoration: underline;">${song.author || 'Unknown Creator'}</a>`;
    } else if (song.author && song.user) {
        // Default Suno-specific logic
        authorDiv.innerHTML = `Creator: <a href="https://suno.com/@${encodeURIComponent(song.user)}" target="_blank" style="color: inherit; text-decoration: underline;">${song.author}</a>`;
    } else {
        // Fallback if author or user is not available
        authorDiv.textContent = 'Unknown Creator';
    }
}



            // Update the download link dynamically
            const downloadLink = document.getElementById('download-link');
            if (downloadLink) {
                const author = encodeURIComponent(song.author || 'Unknown Author');
                const songName = encodeURIComponent(song.title || 'Unknown Title');
                const downloadUrl = `${downloadPageUrl}?author=${author}&song=${songName}&link=${encodeURIComponent(songUrl)}`;
                downloadLink.href = downloadUrl;
            }
                document.title = song.title || 'Unknown Title';



            // Update the spinner link dynamically
            const spinnerLink = document.getElementById('spinnerLink');
            if (spinnerLink) {
                if (song.uuid.includes('storage.googleapis.com/udio-artifacts') && song.user) {
                    spinnerLink.href = `https://www.udio.com/songs/${encodeURIComponent(song.user)}`;
                } else {
                    spinnerLink.href = `https://suno.com/song/${encodeURIComponent(song.uuid)}`;
                }
                console.log(`Spinner link updated to: ${spinnerLink.href}`);
            } else {
                console.error('Spinner link element not found.');
            }

            // Use the image from JSON if available; otherwise, load a random image
            if (song.image) {
                setBackgroundImage(song.image);
                
            } else {
                loadRandomImage(enableNextButton);
            }
enableNextButton();
proxyPopup.style.display = 'none';




            })
            .catch(error => {
                console.error('Error loading song:', error);
                enableNextButton();
proxyPopup.style.display = 'none';
            });
    }

    function loadRandomImage(callback) {
        const imageDirectories = [
            'https://xtdevelopment.net/eve_images/eve1/',
            'https://xtdevelopment.net/eve_images/eve2/',
            'https://xtdevelopment.net/eve_images/eve3/',
            'https://xtdevelopment.net/eve_images/eve4/',
            'https://xtdevelopment.net/eve_images/eve5/',
            'https://xtdevelopment.net/eve_images/eve6/',
            'https://xtdevelopment.net/eve_images/eve7/',
            'https://xtdevelopment.net/eve_images/eve8/',
            'https://xtdevelopment.net/eve_images/eve9/',
            'https://xtdevelopment.net/eve_images/eve10/',
            'https://xtdevelopment.net/eve_images/eve11/',
            'https://xtdevelopment.net/eve_images/eve12/',
            'https://xtdevelopment.net/eve_images/eve13/',
            'https://xtdevelopment.net/eve_images/eve14/',
            'https://xtdevelopment.net/eve_images/eve15/',
            'https://xtdevelopment.net/eve_images/ai1/',
            'https://xtdevelopment.net/eve_images/ai2/',
            'https://xtdevelopment.net/eve_images/ai3/',
            'https://xtdevelopment.net/eve_images/ai4/',
            'https://xtdevelopment.net/eve_images/ai5/',
            'https://xtdevelopment.net/eve_images/ai6/',
            'https://xtdevelopment.net/eve_images/ai7/',
            'https://xtdevelopment.net/eve_images/ai8/',
            'https://xtdevelopment.net/eve_images/eve16/'
        ];
        const imageExtensions = ['png', 'jpg', 'jpeg', 'gif'];
        const directoryURL = imageDirectories[Math.floor(Math.random() * imageDirectories.length)];

        fetch(directoryURL)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const imageLinks = Array.from(doc.querySelectorAll('a'))
                    .map(link => link.getAttribute('href'))
                    .filter(href => {
                        const extension = href.split('.').pop().toLowerCase();
                        return imageExtensions.includes(extension);
                    });

                if (imageLinks.length > 0) {
                    const randomImage = imageLinks[Math.floor(Math.random() * imageLinks.length)];
                    const backgroundImageUrl = `${directoryURL}${randomImage}`;

                    const img = new Image();
                    img.onload = () => {
                        const styleElement = document.getElementById('dynamic-background-style') || document.createElement('style');
                        styleElement.id = 'dynamic-background-style';
                        styleElement.innerHTML = `
                            .background-container::before {
                                content: "";
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                background-image: url('${backgroundImageUrl}');
                                background-size: cover;
                                background-position: center;
                                background-repeat: no-repeat;
                                transform-origin: 50% calc(50% - 100px);
                                animation: zoom-in-out 60s infinite ease-in-out;
                            }
                        `;
                        document.head.appendChild(styleElement);

                        if (typeof callback === 'function') {
                            callback();
                        }
                    };

                    img.onerror = () => {
                        console.error('Failed to load image:', backgroundImageUrl);
                        if (typeof callback === 'function') {
                            callback();
                        }
                    };

                    img.src = backgroundImageUrl;





                } else {
                    console.error('No images found in the directory.');
                    if (typeof callback === 'function') {
                        callback();
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching random image:', error);
                if (typeof callback === 'function') {
                    callback();
                }
            });
    }




    function disableNextButton() {
        playlistDiv.style.display = 'none';

        moreButton.disabled = true;
        nextButton.disabled = true;
        moreButton.style.cursor = 'not-allowed';
        nextButton.style.cursor = 'not-allowed';
        moreButton.style.opacity = '0.6';
        nextButton.style.opacity = '0.6';
    }

    function enableNextButton() {
        moreButton.disabled = false;
        nextButton.disabled = false;
        moreButton.style.cursor = 'pointer';
        nextButton.style.cursor = 'pointer';
        moreButton.style.opacity = '1';
        nextButton.style.opacity = '1';
    }
}
});


document.addEventListener('DOMContentLoaded', () => {
    const popupCanvas = document.getElementById('popupCanvas');
    const audioContainer = document.getElementById('audio-container');
if(!isVideo){
const randomSongContainer3 = document.querySelector('#random-song-container');
randomSongContainer3.style.bottom = '90px'; // Clear the left position to avoid conflicts

randomSongContainer3.style.left = '5px'; // Clear the left position to avoid conflicts

}


    if (isVideo && popupCanvas) {
const randomSongContainer = document.getElementById('random-song-container');
audioContainer.style.maxHeight  = '50%'; 
audioContainer.style.height  = '50vh';
audioContainer.style.maxWidth  = '90%'; 
audioContainer.style.position  = 'absolute'; 
audioContainer.style.justifySelf  = 'center'; 
//audioContainer.style.display = 'grid';
//audioContainer.style.alignSelf = 'self-end'; // Vertically center
const parentDiv = document.getElementById('parent-container');
parentDiv.style.display = 'grid';
parentDiv.style.justifyItems = 'center';
parentDiv.style.alignItems = 'center';
const logoContainer = document.getElementById('logo-container');

// Modify the `top` property to move it higher on the page
logoContainer.style.top = '30%'; // Adjust this value as needed



      if (window.innerWidth < 800) {
    if (randomSongContainer) {
if (!isInIframe()) {
        randomSongContainer.style.bottom = '70%'; // Adjust bottom position
}
    }
}
randomSongContainer.style.bottom = 'none'; // Adjust bottom position
  randomSongContainer.style.top = '50px'; // Adjust bottom position
const randomSongContainer2 = document.querySelector('#random-song-container');

randomSongContainer2.style.left = 'none'; // Clear the left position to avoid conflicts

  randomSongContainer2.style.right = '5px'; // Adjust bottom position

        randomSongContainer.style.zIndex = '10001'; // Adjust z-index

        popupCanvas.style.zIndex = '10000'; // Set z-index to 10000 when in isVideo mode
popupCanvas.style.width = 'auto'; 
popupCanvas.style.height = 'auto'; 
        console.log('Updated popupCanvas z-index to 10000 for video mode');
popupCanvas.style.position  = 'relative';
popupCanvas.style.justifySelf = 'center';


    }
});

</script>

    <div id="playlistDiv">
        <ul id="songList"></ul>
    </div>

<script>

//playlist
// Get references to elements
const togglePlaylistBtn = document.getElementById('toggle-playlist-btn');
const playlistDiv = document.getElementById('playlistDiv');

// Event listener for the playlist toggle button
togglePlaylistBtn.addEventListener('click', initializePlaylist);

function initializePlaylist() {
    // Remove the current event listener
    togglePlaylistBtn.removeEventListener('click', initializePlaylist);

    // Define and initialize all variables inside the function
    const songList = document.getElementById('songList');
    const audioPlayer = document.getElementById('audio');
    const songTitleDiv = document.getElementById('song-title'); // Title div
    const authorDiv = document.getElementById('author'); // Author area
    const spinnerImage = document.getElementById('logo'); // Spinner element
    const moreButton = document.getElementById('toggle-playlist-btn');
    const nextButton = document.getElementById('random-song-btn');

    let currentIndex = 0;

    // Ensure the playlist is loaded
    let playlist = window.playlist || null;
    if (!playlist && typeof UserPlaylist !== 'undefined') {
        console.log('Loading playlist from UserPlaylist...');
        playlist = UserPlaylist; // Assign from global `UserPlaylist`
    }

    if (!playlist || !Array.isArray(playlist) || playlist.length === 0) {
        console.error('Playlist is empty or not accessible. Ensure it is globally available.');
        return;
    }

    console.log("Playlist loaded successfully:", playlist);

    // Populate the playlist UI
    playlist.forEach((song, index) => {
        const li = document.createElement('li');
        li.textContent = `${index + 1}. ${song.author || 'Unknown Artist'} - ${song.title || `Track ${index + 1}`}`;
        li.dataset.index = index; // Store the index for click handling
        songList.appendChild(li);
    });
    let songUrl='';
    const proxyPopup = document.getElementById("proxying-popup");

    // Function to disable buttons
    const disableButtons = () => {

        moreButton.disabled = true;
        nextButton.disabled = true;
        moreButton.style.cursor = 'not-allowed';
        nextButton.style.cursor = 'not-allowed';
        moreButton.style.opacity = '0.6';
        nextButton.style.opacity = '0.6';
    };

    // Function to enable buttons
    const enableButtons = () => {

        moreButton.disabled = false;
        nextButton.disabled = false;
        moreButton.style.cursor = 'pointer';
        nextButton.style.cursor = 'pointer';
        moreButton.style.opacity = '1';
        nextButton.style.opacity = '1';
    };





    // Function to play a song
    const playSong = (index) => {
        if (index < 0 || index >= playlist.length) {
            console.error('Index out of bounds.');
            return;
        }

        const song = playlist[index];
        if (!song.uuid) {
            console.error('Song UUID is missing:', song);
            return;
        }

    if ((song.uuid).includes('http')) {
        // Show the popup
        proxyPopup.style.display = 'block';
}

        // Construct the song URL

                    // Hide the playlist div
        disableButtons();

                    playlistDiv.style.display = 'none';


    if (song.uuid.startsWith('http')) {
        songUrl = 'https://rpc.nanocheeze.com:8111/serve-mp3?url='+song.uuid; // Use the external URL directly
    } else {
        songUrl = `https://cdn1.suno.ai/${song.uuid}.mp3`; // Default Suno logic
    }



        // Fetch the song as a blob
        fetch(songUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }



                return response.blob();
            })
            .then(blob => {
                const blobUrl = URL.createObjectURL(blob); // Create a blob URL for playback
                audioPlayer.src = blobUrl;
                audioPlayer.play()
                    .then(() => {
                        console.log(`Now playing: ${song.title || 'Unknown Title'}`);
                        currentIndex = index; // Update the current index



                        // Update UI components dynamically
                        updateSongTitle(song);
                        updateAuthorArea(song);
                        updateEmbedLink(song);
                        updateBackgroundImage(song);
                        updateDownloadLink(song);

                        // Use the existing `swapSpinnerImage` function
                        const profileUrl = song.profile || `https://cdn1.suno.ai/${song.uuid}.webp`;
                        if (songUrl.startsWith('http')) {
                            console.log('Udio song');
                        }else{
                        swapSpinnerImage(profileUrl);
                        
                        }
                        enableButtons(); // Enable buttons even if fetching fails
    if ((song.uuid).includes('http')) {
        proxyPopup.style.display = 'none';}
                    })
                    .catch(err => {
                        console.error('Playback error:', err);
                        enableButtons(); // Enable buttons even if fetching fails
    if ((song.uuid).includes('http')) {
        proxyPopup.style.display = 'none';}
                    });
            })
            .catch(err => {
                console.error('Error fetching the song blob:', err);
                enableButtons(); // Enable buttons even if fetching fails
    if ((song.uuid).includes('http')) {
        proxyPopup.style.display = 'none';}
            });
    };

    // Helper functions to update UI
    const updateSongTitle = (song) => {
        if (songTitleDiv) {
            songTitleDiv.textContent = `${song.author || 'Unknown Artist'} - ${song.title || 'Unknown Title'}`;
        }
    };

    const updateAuthorArea = (song) => {
        if (authorDiv) {

            if (song.uuid.includes("storage.googleapis.com/udio-artifacts") && song.user) {
authorDiv.innerHTML = `Creator: <a href="https://www.udio.com/songs/${encodeURIComponent(song.user)}" target="_blank">${song.author}</a>`;
            }
            else if (song.author && song.user) {
                authorDiv.innerHTML = `Creator: <a href="https://suno.com/@${encodeURIComponent(song.user)}" target="_blank">${song.author}</a>`;
            } else {
                authorDiv.innerHTML = "Unknown Creator";
            }


        }
    };

    const updateEmbedLink = (song) => {
        const embedLink = document.querySelector("#spinnerLink");
        if (song.uuid.includes("storage.googleapis.com/udio-artifacts") && song.user) {
            // For udio.com URLs, append the user field
            embedLink.href = `https://www.udio.com/songs/${encodeURIComponent(song.user)}`;
        } else {
            // Default behavior for other URLs
            embedLink.href = song.uuid ? `https://suno.com/song/${song.uuid}` : '#';
        }
    };

    const updateBackgroundImage = (song) => {
        if (song.image) {
            const styleElement = document.getElementById('dynamic-background-style') || document.createElement('style');
            styleElement.id = 'dynamic-background-style';
            styleElement.innerHTML = `
                .background-container::before {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-image: url('${song.image}');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    transform-origin: 50% calc(50% - 100px);
                    animation: zoom-in-out 60s infinite ease-in-out;
                }
            `;
            document.head.appendChild(styleElement);
        }
    };

const updateDownloadLink = (song) => {
    const downloadLink = document.getElementById('download-link');
    if (downloadLink) {
        // Construct the appropriate song URL
        let songUrl;
        if (song.uuid.startsWith('http')) {
            songUrl = `https://rpc.nanocheeze.com:8111/serve-mp3?url=${encodeURIComponent(song.uuid)}`;
        } else {
            songUrl = `https://cdn1.suno.ai/${song.uuid}.mp3`; // Default Suno logic
        }

        // Use the song and author metadata to construct the download URL
        const songTitle = song.title || 'Unknown Title';
        const authorName = song.author || 'Unknown Author';
        const downloadUrl = `https://xtdevelopment.net/music/download/?author=${encodeURIComponent(authorName)}&song=${encodeURIComponent(songTitle)}&link=${encodeURIComponent(songUrl)}`;

        // Update the download link
        downloadLink.href = downloadUrl;
        console.log(`Download link updated to: ${downloadUrl}`);
    } else {
        console.error('Download link element not found.');
    }
};



if (songUrl.startsWith('http')) {
console.log('Udio song, no profile images accessible');
}
else{
    const swapSpinnerImage = (profileUrl) => {
          if (spinnerImage && profileUrl) {
        console.log(`Swapping spinner image to profile picture: ${profileUrl}`);
        //spinnerImage.src = profileUrl;
        newLogo = profileUrl;
    } else {
        console.warn('Spinner image or profile URL is missing.');
    }
    };
}

    // Handle clicks on playlist items
    songList.addEventListener('click', (event) => {
        const target = event.target;
        if (target.tagName === 'LI') {
            const index = parseInt(target.dataset.index, 10);
            if (!isNaN(index)) playSong(index);
        }
    });

    // Add spacebar toggle for the playlist div
    document.addEventListener('keydown', (event) => {
        if (event.code === 'Space') {
            event.preventDefault();
            togglePlaylistVisibility();
        }
    });

    // Attach toggle functionality after initialization
    togglePlaylistBtn.addEventListener('click', togglePlaylistVisibility);

    // Show the playlist by default after initialization
    playlistDiv.style.display = 'block';
    console.log("Playlist initialized and displayed.");
}

function togglePlaylistVisibility() {
    if (playlistDiv.style.display === 'none' || playlistDiv.style.display === '') {
        playlistDiv.style.display = 'block';
        console.log("Playlist is now visible.");
    } else {
        playlistDiv.style.display = 'none';
        console.log("Playlist is now hidden.");
    }
}



    const moreButton = document.getElementById('toggle-playlist-btn');

    if (!moreButton) {
        console.error('More button not found!');
    }

    // Get the URL parameters
    const urlParams4 = new URLSearchParams(window.location.search);

    // Check if the "playlist" parameter exists
    if (!urlParams4.has('playlist')) {
        // Hide the "More" button if the "playlist" parameter is not present
        moreButton.style.display = 'none';
    }

//cors error check










//end cors error check

</script>

<?php
if (isset($_GET['playlist'])){
echo "<div id='author' style='z-index: 20000; position: absolute; bottom: 100px; left: 50%; transform: translateX(-50%); background: rgba(0, 0, 0, 0.6); padding: 10px 20px; border-radius: 10px; text-align: center; font-size: 0.5rem;'></div>";
}
else{
echo "<div id='author'></div>";
}
?>

<div id="download-container" style="position: absolute; top: 20px; left: 10px; z-index: 5000;">
    <a id="download-link" href="<?php echo htmlspecialchars($downloadUrl); ?>" target="_blank" style="display: inline-block;">
        <img src="download-icon.png" alt="Download" style="width: 30px; height: auto; cursor: pointer;">
    </a>
</div>


<div id="proxying-popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10000; background: rgba(0, 0, 0, 0.8); color: white; padding: 20px; border-radius: 10px; text-align: center; font-size: 0.6rem; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);">
    Proxying Your File...<br/>Please continue to enjoy the current song<br/>while your song loads...
</div>


<div class="background-container"></div>
</body>
        </html>
