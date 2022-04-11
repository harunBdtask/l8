// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    databaseURL: 'https://bdtask-316806.firebaseio.com',
    apiKey: "AIzaSyDB8HVZ4Ab6URG8pbvlqeIk1fJPLvr_x48",
    authDomain: "bdtask-316806.firebaseapp.com",
    projectId: "bdtask-316806",
    storageBucket: "bdtask-316806.appspot.com",
    messagingSenderId: "601662239357",
    appId: "1:601662239357:web:7b9e0af15c2ca103533714",
    measurementId: "G-9PQ9CSW27N"
});


// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});