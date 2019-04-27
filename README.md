# Open Playlist with Spotify API


<img width="100" src="https://raw.githubusercontent.com/charrismatic/open-playlist/master/public/assets/high-volume.png">

Originally developed for a New Years party so people in other cities could add music to the playlist and all listen together. It's also quite useful if you know people that always like to make song requests but you don't like to give up the aux cable. 


Link to the example playist on Spotify: https://open.spotify.com/user/mjharris2407/playlist/5J5woWIVKETFIugsyxexZI?si=PMQLsFHuTDWHS8tYawVewA


## Installing 

1. Copy the `.env_example` file to `.env` in the project root

2. Get your app credentials from the [Spotify Developer Dashboard](https://developer.spotify.com/dashboard/applications)

3. Install the dependencies

```
npm install 
```

4. Run the application  

```javascript 
node app.js
```

5. Go to `localhost:8888` in the browser

## Additional Setup on Spotify 

You need to add your own spotify user id and create a new playlist that you would like to interact with through the api

The playlist in the example will only work with the correct account and access tokens.



### References Spotify Spotify

Spotify Web Api Issue Tracker

[github.com/spotify/web-api](https://github.com/spotify/web-api)

Spotify Developer | Web API User Guide

[developer.spotify.com/web-api/user-guide](https://developer.spotify.com/web-api/user-guide)
Test App Config:


*You will need your own API credentials to use this application*

Visit https://developer.spotify.com to setup your api credentials

```
Application Name: spotify_demo
Client ID: xxx
Client Secret: xxx
```
