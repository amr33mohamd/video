@extends('layout')
@section('content')

    <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
$(document).ready(function(){
//   if (location.protocol !== 'https:') {
//     location.replace(`https:${location.href.substring(location.protocol.length)}`);
// }

})
    Twilio.Video.createLocalTracks({
       audio: true,
       video: { width: 300 }
    }).then(function(localTracks) {
       return Twilio.Video.connect('{{ $accessToken }}', {
           name: '{{ $roomName }}',
           tracks: localTracks,
           video: { width: 150 }
       });
    }).then(function(room) {
      room = room;
       console.log('Successfully joined a Room: ', room.name);
       room.participants.forEach(participantConnected);




       var previewContainer = document.getElementById(room.localParticipant.sid);
       if (!previewContainer || !previewContainer.querySelector('video')) {
           participantConnected(room.localParticipant);
       }

       room.on('participantConnected', function(participant) {
           console.log("Joining: ",  participant.identity   );
           participantConnected(participant);
       });

       room.on('participantDisconnected', function(participant) {
           console.log("Disconnected: ",   participant.identity   );
           participantDisconnected(participant);
       });

       $(document).ready(function(){
$('#microphone').click(()=>{
     room.localParticipant.audioTracks.forEach(function (audioTrack) {
      if($("#microphone").attr('to')== 'mute'){
     //participant audio track disable.
     $('#microphone').attr('to','unmute');

     $("#microphone").removeClass('fa-volume-off');
     $("#microphone").addClass('fa-volume-mute')

     audioTrack.mediaStreamTrack.muted = true;
     audioTrack.disable();




      }
      else {
        audioTrack.mediaStreamTrack.muted = false;
        audioTrack.enable();
        $('#microphone').attr('to','mute');
        $("#microphone").addClass('fa-volume-off');
        $("#microphone").removeClass('fa-volume-mute')

      }
    });

})



       })
    });

    function participantConnected(participant) {
   console.log('Participant "%s" connected', participant.identity);

   const div = document.createElement('div');
   div.id = participant.identity;
   div.setAttribute("style", " margin: 10px;");


   participant.tracks.forEach(function(track) {
       trackAdded(div, track)
   });

   participant.on('trackAdded', function(track) {
       trackAdded(div, track)
   });
   participant.on('trackRemoved', trackRemoved);

   document.getElementById('media-div').appendChild(div);
}

function participantDisconnected(participant) {
   console.log('Participant "%s" disconnected', participant.identity);

   participant.tracks.forEach(trackRemoved);
   document.getElementById(participant.identity).remove();
}

function trackAdded(div, track) {
   div.appendChild(track.attach());
   var video = div.getElementsByTagName("video")[0];
   if (video) {
       video.setAttribute("class", "col-sm-9");
       video.setAttribute("style", "display:block;margin:0 auto");


   }

}

function trackRemoved(track) {
   track.detach().forEach( function(element) { element.remove() });
}




setTimeout(function(){
  const videome = document.getElementById("{{$auth}}").querySelector('video');
  videome.setAttribute("class", "col-sm-2");


},4000)

setTimeout(function(){
  const videome = document.getElementById("{{$auth}}").querySelector('video');
  videome.setAttribute("class", "col-sm-2");


},6000)
setTimeout(function(){
    const videome = document.getElementById("{{$auth}}").querySelector('video');
    videome.setAttribute("class", "col-sm-2");


},9000)

var  muteVideo = () =>{


        if($("#camera").attr('to')== 'mute'){
          const video = document.getElementById("{{$auth}}").querySelector('video');

          // A video's MediaStream object is available through its srcObject attribute
          const mediaStream = video.srcObject;

          // Through the MediaStream, you can get the MediaStreamTracks with getTracks():
          const tracks = mediaStream.getTracks();
console.log(tracks);
          // Tracks are returned as an array, so if you know you only have one, you can stop it with:
          tracks[0].stop();

          $('#camera').attr('to','unmute');

          $("#camera").removeClass('fa-camera');
          $("#camera").addClass('fa-stop')

        }
        else {
location.reload();
          // Or stop all like so:
          $('#camera').attr('to','mute');
          $("#camera").addClass('fa-camera');
          $("#camera").removeClass('fa-stop')


        }


}


var  muteAudio = () =>{


}
    // additional functions will be added after this point
</script>




<!-- Main Wrapper -->
<div class="main-wrapper">

  <!-- Header -->

  <!-- /Header -->

  <!-- Page Content -->
  <div class="content">
<iframe width="1049" height="590" src="https://www.youtube.com/embed/g6BprD_IIl4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js" type="text/javascript"></script>
<script>
// var NowMoment = moment();
// moment().format();

// setInterval(function(){
//
//   var end_time = '{{$end_time}}';
//   // var end_time = '13:00:00';
// if(moment().isBefore(moment(end_time,"hh:mm:ss"))){
// console.log('safe')
// }
// else {
//    window.location.replace("/review/{{$roomName}}");
//
// }
// }, 5000 ) // after 5 seconds

</script>



    @endsection
