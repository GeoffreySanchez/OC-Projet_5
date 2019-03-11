var player;
function onYouTubePlayerAPIReady() {
    var dataUrl = document.querySelector('#player');
    var videoUrl = dataUrl.dataset.videoUrl;

    player = new YT.Player('player', {
        height: '360',
        width: '640',
        videoId: videoUrl,
        playerVars: {
            'controls': 0,
            'disablekb': 1,
        },
        events: {
            'onStateChange': onPlayerStateChange
        }
    });
}

// Lorsque la vidéo est fini
function onPlayerStateChange(event) {
    var dataUrl = document.querySelector('#player');
    var videoId = dataUrl.dataset.videoId;
    var videoTicket = dataUrl.dataset.videoTicket;
    var videoPath = dataUrl.dataset.videoPath;

    if (event.data === 0) {
        $RemoveVideoDiv = document.getElementById('player').remove();
        var divVideo = document.getElementById('videoForTickets');

        //Création du formulaire
        var f = document.createElement("form");
        f.setAttribute('id', 'videoForm');
        f.setAttribute('action', videoPath);
        f.setAttribute('method', "post");
        document.getElementById('videoForTickets').appendChild(f);
        //création du boutton
        var b = document.createElement("button");
        var bText = document.createTextNode('Gagner ' + videoTicket + ' tickets');
        b.setAttribute('type', "submit");
        b.setAttribute('class', "btn btn-success");
        b.setAttribute('name', "winTickets");
        b.setAttribute('value', videoId);
        b.appendChild(bText);
        document.getElementById('videoForm').appendChild(b);
    }
}