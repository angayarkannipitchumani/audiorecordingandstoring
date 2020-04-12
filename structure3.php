   <html>
<head>
	<style>
* {
  box-sizing: border-box;
}
 #recordingslist audio {
                display: block;
                margin-bottom: 10px;
            }
body {
  font-family: Arial;
  padding: 10px;
  background: #f1f1f1;
}

/* Header/Blog Title */
.header {
  padding: 30px;
  text-align: center;
  background: white;
}

.header h1 {
  font-size: 50px;
}

/* Style the top navigation bar */
.topnav {
  overflow: hidden;
  background-color: #333;
}

/* Style the topnav links */
.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Create two unequal columns that floats next to each other */
/* Left column */
.leftcolumn {   
  float: left;
  width: 75%;
}

/* Right column */
.rightcolumn {
  float: left;
  width: 25%;
  background-color: #f1f1f1;
  padding-left: 20px;
}

/* Fake image */
.fakeimg {
  background-color: #aaa;
  width: 100%;
  padding: 20px;
}

/* Add a card effect for articles */
.card {
  background-color: white;
  padding: 20px;
  margin-top: 20px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Footer 
.footer {
  padding: 20px;
  text-align: center;
  background: #ddd;
  margin-top: 20px;
}*/

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 800px) {
  .leftcolumn, .rightcolumn {   
    width: 100%;
    padding: 0;
  }
}

/* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
@media screen and (max-width: 400px) {
  .topnav a {
    float: none;
    width: 100%;
  }
}
</style>
<style>
		.editor
        {
			border:solid 1px #ccc;
			padding: 20px;
			min-height:200px;
        }

        .sample-toolbar
        {
			border:solid 1px #ddd;
			background:#f4f4f4;
			padding: 5px;
			border-radius:3px;
        }

        .sample-toolbar > span
        {
			cursor:pointer;
		}

        .sample-toolbar > span:hover
        {
			text-decoration:underline;
		}
* {
  box-sizing: border-box;
}
.menu {
  float:left;
  width:20%;
  text-align:center;
}
.menu a {
  background-color:#e5e5e5;
  padding:8px;
  margin-top:7px;
  display:block;
  width:100%;
  color:black;
}
.main {
  float:left;
  width:60%;
  padding:0 20px;
}
.right {
  background-color:#e5e5e5;
  float:left;
  width:20%;
  padding:15px;
  margin-top:7px;
  text-align:center;
}

@media only screen and (max-width:620px) {
  /* For mobile phones: */
  .menu, .main, .right {
    width:100%;
  }
}
	</style>
</head>



<body lang=EN-US style='tab-interval:.5in' onload="init()">
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<!--<form method="post" name="element" id="element" enctype=“multipart/form-data” action="insert3.php">-->
<form action="insert3.php" method="post" enctype="multipart/form-data">
<input name="hidden_data" id='hidden_data' type="hidden"/>

<div class="header">
  <h1>STRUCTURE AND FUNCTION THEORY</h1>
  <p>Resize the browser window to see the effect.</p>
</div>

<div class="topnav">
  
  <a href="#activity">TEACHER PROPOSED ACTIVITY </a>

</div>


   <div class="card">
    <a id="activity">
      <h2>Teacher Proposed Activity  </h2></a>
      <h2> Activity 3a: Leaves </h2>
      
            
    </div>
  <div class="card">
    <div class="card">
      <h2>Activities</h2>

<ul>
<li>Bring a potted plant to class and have the class observe the plant. </li>
<li>Cover one branch and its leaves with a clear plastic bag and make a tight seal around the branch. </li>
<li>Ask students to look at the branch, leaves, and plastic bag as soon as it has been attached. </li>
<li>Water the plant as needed and observe the bag over the next couple of days. </li>
<li>Condensation should develop inside the bag. Ask students to tell you why.</li>

</ul>
<h1>Record Your Students Discussion</h1>

    <p>Make sure you are using a recent version of Google Chrome.</p>
    <p>Also before you enable microphone input either plug in headphones or turn the volume down if you want to avoid ear splitting
        feedback!
    </p>



         
</div>
</div>


 
 <!-- Draw the action buttons -->
    <input type="button" id="start-btn" value="Start recording"></input>
    <input type="button" id="stop-btn" value="Stop recording"disabled></input>


    <!-- List item to store the recording files so they can be played in the browser -->
    <h2>Stored Recordings</h2>
    <ul id="recordingslist"></ul>
   <script>
        // Expose globally your audio_context, the recorder instance and audio_stream
        var audio_context;
        var recorder;
        var audio_stream;
var aud;

        /**
         * Patch the APIs for every browser that supports them and check
         * if getUserMedia is supported on the browser. 
         * 
         */
        function Initialize() {
            try {
                // Monkeypatch for AudioContext, getUserMedia and URL
                window.AudioContext = window.AudioContext || window.webkitAudioContext;
                navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
                window.URL = window.URL || window.webkitURL;
                aud=document.getElementById("aus");
                // Store the instance of AudioContext globally
                audio_context = new AudioContext;
                console.log('Audio context is ready !');
                console.log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
            } catch (e) {
                alert('No web audio support in this browser!');
            }
        }
 
        /**
         * Starts the recording process by requesting the access to the microphone.
         * Then, if granted proceed to initialize the library and store the stream.
         *
         * It only stops when the method stopRecording is triggered.
         */
        function startRecording() {
            // Access the Microphone using the navigator.getUserMedia method to obtain a stream
            navigator.getUserMedia({ audio: true }, function (stream) {
                // Expose the stream to be accessible globally
                audio_stream = stream;
                // Create the MediaStreamSource for the Recorder library
                var input = audio_context.createMediaStreamSource(stream);
                console.log('Media stream succesfully created');

                // Initialize the Recorder Library
                recorder = new Recorder(input);
                console.log('Recorder initialised');

                // Start recording !
                recorder && recorder.record();
                console.log('Recording...');

                // Disable Record button and enable stop button !
                document.getElementById("start-btn").disabled = true;
                document.getElementById("stop-btn").disabled = false;
            }, function (e) {
                console.error('No live audio input: ' + e);
            });
        }

        /**
         * Stops the recording process. The method expects a callback as first
         * argument (function) executed once the AudioBlob is generated and it
         * receives the same Blob as first argument. The second argument is
         * optional and specifies the format to export the blob either wav or mp3
         */
        function stopRecording(callback, AudioFormat) {
            // Stop the recorder instance
            recorder && recorder.stop();
            console.log('Stopped recording.');

            // Stop the getUserMedia Audio Stream !
            audio_stream.getAudioTracks()[0].stop();

            // Disable Stop button and enable Record button !
            document.getElementById("start-btn").disabled = false;
            document.getElementById("stop-btn").disabled = true;

            // Use the Recorder Library to export the recorder Audio as a .wav file
            // The callback providen in the stop recording method receives the blob
            if(typeof(callback) == "function"){

                /**
                 * Export the AudioBLOB using the exportWAV method.
                 * Note that this method exports too with mp3 if
                 * you provide the second argument of the function
                 */
                recorder && recorder.exportWAV(function (blob) {
                    callback(blob);

                    // create WAV download link using audio data blob
                    // createDownloadLink();

                    // Clear the Recorder to start again !
                    recorder.clear();
                }, (AudioFormat || "audio/wav"));
            }
        }

        // Initialize everything once the window loads
        window.onload = function(){
            // Prepare and check if requirements are filled
            Initialize();

            // Handle on start recording button
            document.getElementById("start-btn").addEventListener("click", function(){
                startRecording();
            }, false);

            // Handle on stop recording button
            document.getElementById("stop-btn").addEventListener("click", function(){
                // Use wav format
                var _AudioFormat = "audio/wav";
                // You can use mp3 to using the correct mimetype
                //var AudioFormat = "audio/mpeg";

                stopRecording(function(AudioBLOB){
                    // Note:
                    // Use the AudioBLOB for whatever you need, to download
                    // directly in the browser, to upload to the server, you name it !

                    // In this case we are going to add an Audio item to the list so you
                    // can play every stored Audio
                    var url = URL.createObjectURL(AudioBLOB);
                    var li = document.createElement('li');
                    var au = document.createElement('audio');
                    var hf = document.createElement('a');
aud=document.getElementById("aus");
aud.src=url;

                    //au.controls = true;
                    au.src = url;
                    hf.href = url;
                    // Important:
                    // Change the format of the file according to the mimetype
                    // e.g for audio/wav the extension is .wav 
                    //     for audio/mpeg (mp3) the extension is .mp3
                    hf.download = new Date().toISOString() + '.wav';
                    hf.innerHTML = hf.download;
                    li.appendChild(au);
                    li.appendChild(hf);
document.getElementById('aus').appendChild(au);
document.getElementById('hidden_data').value = aud.src;
                    recordingslist.appendChild(li);
                }, _AudioFormat);
            }, false);
        };


    </script>
<script>




</script>
    <!-- Include the recorder.js library from a local copy -->
    <script src="recorder.js"></script>
 <audio controls id="aus">
  <source src=" " type="audio/wav">
 
</audio> 
<p><font color="red"> 1. Click on the Audio file Link in blue color to download</font></p>
<p><font color="red"> 2. Choose the audio file downloaded and upload the same</font></p>
<label for="fileSelect">Filename:</label>
        <input type="file" name="photo" id="fileSelect">
        <input type="submit" name="submit" value="Upload">



<hr/>
</form>

</body>
</html>
 
