let jsonresp;
  let sessionId;
  let tokenId;
  let check;
  var pubOptions = {videoSource: null};
  $('#session').click(function(){
   $.ajax({
    "url":"getsession.php",
    "cache":false,
    "success":function(resp){
       jsonresp = JSON.parse(resp);
       sessionId = jsonresp.sessionId;
       tokenId = jsonresp.tokenId;
       check = jsonresp.check;

      console.log(sessionId);
      console.log(tokenId);
      console.log(check);
       initializeSession(check,sessionId);
    }

    });
  initializeSession(46221742,"1_MX40NjIyMTc0Mn5-MTU0MzIxNTkyNTM3N35vOS8zTHM4d1FCdForTS91ZTNEaUprM0F-UH4");
  });
  
  // function initializeSession(apiKey,sessionId) {
  //   alert("i am in session");
    function initializeSession(apiKey,sessionId) {
  var session = OT.initSession(apiKey, sessionId);

//   // Subscribe to a newly created stream
  session.on('streamCreated', function(event) {
  session.subscribe(event.stream, 'subscriber', {
    insertMode: 'append',
    width: '100%',
    height: '100%'
  }, handleError);
});
//   // Create a publisher
  var publisher = OT.initPublisher('publisher', {
    insertMode: 'append',
    width: '100%',
    height: '100%'
  }, handleError);

//   // Connect to the session
  session.connect(tokenId, function(error) {
    // If the connection is successful, publish to the session
    if (error) {
      handleError(error);
    } else {
      //session.publish(publisher, handleError);
      session.publish(publisher);
    }
  });
}

function handleError(error) {
  if (error) {
    alert(error.message);
  }
}
