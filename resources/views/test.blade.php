<x-app-layout>
<!-- Include Video.js library -->
<link href="https://cdn.jsdelivr.net/npm/video.js@7.10.2/dist/video-js.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/video.js@7.10.2/dist/video.min.js"></script>

<!-- Include HLS.js (needed for HLS playback) -->
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>


<video id="video" width="100%" height="auto" controls></video>

<script>
    var video = document.getElementById('video');
    var baseUrl = 'https://movie3.randchange.top/hls/2025/gorge/1080p/video';
    var videoIndex = 0;  // Starting index for the video segment

    if (Hls.isSupported()) {
        console.log("supported");
        var hls = new Hls();
        var videoUrl = baseUrl + videoIndex + '.ts';  // Initial segment URL
        hls.loadSource(videoUrl);
        hls.attachMedia(video);

        hls.on(Hls.Events.MANIFEST_PARSED, function() {
            console.log("Manifest loaded, starting playback");
            video.play();  // Start playback when the manifest is ready
        });

        // Increment the segment index for the next video
        setInterval(function() {
            videoUrl = baseUrl + videoIndex + '.ts';
            hls.loadSource(videoUrl);  // Load the next segment
            hls.startLoad();
            videoIndex++;  // Update the segment number
        }, 2000);  // Update every 2 seconds
    }
</script>



</x-app-layout>
