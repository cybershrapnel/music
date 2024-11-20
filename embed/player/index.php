<?php
if (isset($_GET['song'])) {
    $songToPlay = htmlspecialchars(urldecode($_GET['song'])); // Decode the song name
    $baseDirectory = $_SERVER['DOCUMENT_ROOT'] . "/music/mp3s/"; // Absolute path to the MP3s directory
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



if (!$backgroundImage) {
$backgroundImage = getRandomImage($imageDirectory, $imageExtensions);
}

    // Locate the MP3 file
if (!$UUID){

    $mp3Path = findMp3InSubdirs($songToPlay, $baseDirectory, $extensions);
 }
else{
$mp3Path= "https://cdn1.suno.ai/" . $_GET['song'] . ".mp3";

}

    if ($mp3Path) {
if (!$UUID){
$mp3Url = str_replace("'", "%27", str_replace($_SERVER['DOCUMENT_ROOT'], "https://" . $_SERVER['HTTP_HOST'], $mp3Path));
}
else{
$mp3Url = $mp3Path;
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
    }
#random-song-container {
    position: absolute; /* Matches the button's positioning context */
    bottom: 90px; /* Slightly adjust relative to the button */
    left: 5px; /* Adjusted alignment */
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



<div id='random-song-container'>
   <button id='random-song-btn' style='padding: 10px 15px; font-size: 14px; cursor: pointer;'>Next</button>
</div>

<a target='_blank' href='https://music.nanocheeze.com#" . htmlspecialchars(urlencode($songToPlay)) . "'>
<div id='popupCanvas' style='display: none; position: fixed; top: 80px; left: -250; width: 100%; height: 100%; z-index: 1000;'></div>
</a>
<div style='text-align: center;'>";

if (isset($_GET['title'])){

            echo "<h1 id='song-title' style='background: rgba(0, 0, 0, 0.6); padding: 10px 20px; border-radius: 10px; display: inline-block; text-align: center; position: relative; z-index: 100;'>" . $_GET['title'] . "</h1>";
}
else{
echo "<h1 id='song-title' style='background: rgba(0, 0, 0, 0.6); padding: 10px 20px; border-radius: 10px; display: inline-block; text-align: center; position: relative; z-index: 100;'>" . htmlspecialchars($songToPlay) . "</h1>";
}

echo "
</div>
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
    }

    function initializePopup(event) {
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
        const audio = document.getElementById('audio'); // Existing audio element
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
        let numParticles = int(map(level, 0, 255, 0, 10));
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

<div id='audio-container' style='fixed: absolute; bottom: 10px; width: 100%; display: flex; justify-content: center; z-index: 2000;'>
                
<audio id='audio' controls autoplay loop style='position: fixed; bottom: 10px; width: 98%; display: flex; justify-content: center; z-index: 2000;'>

                <source id='audio-source' src='" . htmlspecialchars($mp3Url) . "' type='audio/mpeg'>
                Your browser does not support the audio element.
            </audio>
            </div>


<div id='animationPopup' style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;'>


    <canvas id='popupCanvas'></canvas>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Function to check if the audio is playing
        function waitForAudioToPlay() {
            const audio = document.getElementById('audio'); // Your audio element
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
                        logoLink.dispatchEvent(event); // Dispatch the event
                        if (logoContainer) {
                            logoContainer.style.display = 'none'; // Make it invisible but retain layout
                        }
                    }
                }
            }, 500); // Check every 500ms
        }

        // Wait 2 seconds, then start checking
        setTimeout(() => {
            waitForAudioToPlay();
        }, 2000); // 2 seconds delay
    });
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
    directoryURL = 'https://xtdevelopment.net/audio/'; // Pick a random song directory
} else {
    directoryURL = getRandomDirectory(songDirectories); // Pick a random song directory
}

    fetch(directoryURL)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const links = Array.from(doc.querySelectorAll('a'))
                .map(link => link.getAttribute('href'))
                .filter(href => href && href.endsWith('.mp3'));

            if (links.length > 0) {
                const randomFile = links[Math.floor(Math.random() * links.length)];
                const songName = randomFile.replace('.mp3', ''); // Remove the .mp3 extension
                const songUrl = directoryURL + encodeURIComponent(randomFile); // Full URL for the song
console.log(songUrl);
                // Update the audio source
                //const audioSource = document.getElementById('audio-source');
                const audio = document.getElementById('audio');
                let audioSource = document.getElementById('audio-source');

                // Check if the source element is missing or detached
                if (!audioSource) {
                    // Create and attach the source element if it doesn't exist
                    audioSource = document.createElement('source');
                    audioSource.id = 'audio-source';
                    audioSource.type = 'audio/mpeg';
                    audio.appendChild(audioSource);
                }

audio.src = songUrl;
                audioSource.src = songUrl;
                audio.load();
                audio.play();

                // Update the displayed song title
                const songTitleElement = document.getElementById('song-title');
                if (songTitleElement) songTitleElement.textContent = songName;

                // Update the spinner link
                const spinnerLink = document.querySelector("a[href*='https://music.nanocheeze.com']");
                if (spinnerLink) {
    spinnerLink.href = `https://music.nanocheeze.com#${encodeURIComponent(songName)}`;
                }
                const downloadLink = document.getElementById('download-link');
                if (downloadLink) {
                    downloadLink.href = `https://xtdevelopment.net/music/download/?author=NanoCheeZe&song=${encodeURIComponent(songName)}&link=${encodeURIComponent(songUrl)}`;
                }
                // Load a new random background image
                loadRandomImage();
            } else {
                alert('No MP3 files found in the directory.');
            }
        })
        .catch(error => console.error('Error fetching directory listing:', error));
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
        songTitle.addEventListener('click', initializePopup); // Handle left-click
        songTitle.addEventListener('contextmenu', initializePopup); // Handle right-click
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const nextButton = document.getElementById('random-song-btn');
    const audioPlayer = document.getElementById('audio');

    if (nextButton && audioPlayer) {
        // Add click event listener to the next button
        nextButton.addEventListener('click', () => {
            // Disable loop mode
            audioPlayer.loop = false;

            // Remove any existing 'ended' event listeners to avoid duplicate handlers
            audioPlayer.removeEventListener('ended', handleTrackEnd);

            // Add event listener to monitor for the end of the file
            audioPlayer.addEventListener('ended', handleTrackEnd);
        });
    }

    // Function to handle track end and trigger the next button
    function handleTrackEnd() {
        console.log('Track ended. Progressing to the next track...');
        nextButton.click(); // Simulate clicking the next button
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

        
document.addEventListener('DOMContentLoaded', () => {
    const footerDiv = document.getElementById('footer');
    const backgroundStyleElement = document.querySelector('.background-container::before');

    if (footerDiv) {
        footerDiv.addEventListener('contextmenu', (event) => {
            event.preventDefault(); // Prevent the default context menu from opening

            // Retrieve the background image URL from the computed style
            const backgroundImage = window.getComputedStyle(document.querySelector('.background-container'), '::before')
                .getPropertyValue('background-image');

            if (backgroundImage && backgroundImage.includes('url')) {
                // Extract the image URL from the background-image property
                const imageUrl = backgroundImage.slice(5, -2); // Remove 'url("...")' wrapping

                // Parse the image URL to extract the directory and file name
                const urlParts = new URL(imageUrl);
                const pathParts = urlParts.pathname.split('/');
                const directory = pathParts[pathParts.length - 2]; // Get the second last segment (directory)
                const fileName = pathParts[pathParts.length - 1]; // Get the last segment (file name)

                // Update the footer content with the directory and file name
                footerDiv.textContent = `Directory: ${directory}, Image: ${fileName}`;
            } else {
                footerDiv.textContent = 'No image found in the background.';
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', () => {
    if (isUUID) {
        const audioElement = document.getElementById('audio');
        
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
            })
            .catch(error => {
                console.error('Error fetching the MP3 file:', error);
            });
    }
});

document.addEventListener('DOMContentLoaded', () => {
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

                if (playlist.length > 0) {
                    loadRandomSong();
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
            console.error('Playlist is empty.');
            alert('No more songs in the playlist!');
            return;
        }

        loadRandomSong();
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

        const songUrl = `https://cdn1.suno.ai/${song.uuid}.mp3`;
    const downloadPageUrl = `https://xtdevelopment.net/music/download/`;

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

                const songTitleElement = document.getElementById('song-title');
                if (songTitleElement) {
                    songTitleElement.textContent = song.title || 'Unknown Title';
                }

// Update author name
if (authorDiv) {
    if (song.author && song.user) {
        authorDiv.innerHTML = `Creator: <a href="https://suno.com/@${encodeURIComponent(song.user)}" target="_blank" style="color: inherit; text-decoration: underline;">${song.author}</a>`;
    } else {
        authorDiv.textContent = ''; // Clear if undefined
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

                // Load a new random image and re-enable the button after it's loaded
                loadRandomImage(enableNextButton);
            })
            .catch(error => {
                console.error('Error loading song:', error);
                enableNextButton();
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
        nextButton.disabled = true;
        nextButton.style.cursor = 'not-allowed';
        nextButton.style.opacity = '0.6';
    }

    function enableNextButton() {
        nextButton.disabled = false;
        nextButton.style.cursor = 'pointer';
        nextButton.style.opacity = '1';
    }
});


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
    <a id="download-link" href="#" target="_blank" style="display: inline-block;">
        <img src="download-icon.png" alt="Download" style="width: 30px; height: auto; cursor: pointer;">
    </a>
</div>


<div class="background-container"></div>
</body>
        </html>
