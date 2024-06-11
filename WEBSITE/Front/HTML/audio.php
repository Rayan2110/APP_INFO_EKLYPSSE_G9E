<!DOCTYPE html>
<html>
<head>
    <title>Audio File Sound Level</title>
</head>
<body>
    <h1>Audio File Sound Level</h1>
    <input type="file" id="audio-file" accept="audio/*">
    <p id="sound-level">Sound level: 0 dB</p>
    <label for="gain-control">Gain:</label>
    <input type="range" id="gain-control" min="0" max="100" value="0" step="1">

    <script>
        const sensorIds = [26,27];

        document.getElementById('audio-file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    audioContext.decodeAudioData(e.target.result, function(buffer) {
                        processAudioBuffer(buffer, audioContext);
                    });
                };
                reader.readAsArrayBuffer(file);
            }
        });

        function processAudioBuffer(buffer, audioContext) {
            const analyser = audioContext.createAnalyser();
            const source = audioContext.createBufferSource();
            const gainNode = audioContext.createGain();

            source.buffer = buffer;
            source.connect(gainNode);
            gainNode.connect(analyser);
            analyser.connect(audioContext.destination);
            analyser.fftSize = 2048;

            const dataArray = new Uint8Array(analyser.frequencyBinCount);

            const gainControl = document.getElementById('gain-control');
            gainControl.addEventListener('input', function() {
                // Convert slider value to an exponential scale for gain
                const exponentialGain = Math.pow(10, this.value / 20);
                gainNode.gain.value = exponentialGain;
                document.getElementById('sound-level').innerText = 'Gain: ' + this.value + ' dB';
            });

            // Initialize gain
            gainControl.dispatchEvent(new Event('input'));

            source.start();

            function getAverageVolume(array) {
                const length = array.length;
                let values = 0;

                for (let i = 0; i < length; i++) {
                    values += array[i];
                }

                return values / length;
            }

            function analyzeAudio() {
                analyser.getByteFrequencyData(dataArray);
                const average = getAverageVolume(dataArray);
                let dB = 20 * (Math.log(average) / Math.log(10));

                if (isNaN(dB) || dB === -Infinity) {
                    dB = -100; // Define a minimal level for silence
                }

                document.getElementById('sound-level').innerText = 'Sound level: ' + dB.toFixed(2) + ' dB';

                // Send sound levels for all sensors
                sensorIds.forEach(sensor_id => {
                    fetch('save_sound_level.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ sensor_id: sensor_id, sound_level: dB.toFixed(2) })
                    }).then(response => response.json())
                      .then(data => console.log(data));
                });
            }

            source.onended = function() {
                clearInterval(interval);
                document.getElementById('sound-level').innerText = 'Audio file ended.';
            };

            const interval = setInterval(analyzeAudio, 200);
        }
    </script>
</body>
</html>