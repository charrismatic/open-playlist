const get_new_access_token = function () {
  $.ajax({
    type: "GET",
    url: '/token',
    success: function (response) {
      token = response;
      get_playlist_data({
        user_id: open_playlist_userid,
        playlist_id: open_playlist_id
      }, token );
    }
  });
}


const refresh_acces_token = function () {
  var endpoint = '/refresh-token';
  $.ajax({
    type: "GET",
    url: endpoint,
    success: function (response) {
      token = response;
      get_playlist_data({
        user_id: open_playlist_userid,
        playlist_id: open_playlist_id
      }, token );
    }
  });
}


/* EXAMPLE
add_track_to_playlist({
  user_id: open_playlist_userid,
  playlist_id: open_playlist_id,
  uri: "spotify:track:7co0X2b0Gu23WbLsn9CLcQ"
});
*/
const add_track_to_playlist = function (data, token) {

  var endpoint = 'https://api.spotify.com/v1/users/' + data.user_id + '/playlists/' + data.playlist_id + '/tracks';
  var query_string = '?uris=' + data.uri + '';
  $.ajax({
    type: "POST",
    url: endpoint+query_string,
    beforeSend: function(xhr){
      xhr.setRequestHeader('Authorization', 'Authorization: Bearer '+ token);
    },
    success: function (response) {
      console.log('response', response);

      get_playlist_data({
        user_id: open_playlist_userid,
        playlist_id: open_playlist_id
      }, token );

      reset_results();
      return true;
    }
  });
}

const track_is_in_playlist = function () {
  return false;
}


const handle_add_track = function (track_html) {

  console.log(track_html);

  if(track_is_in_playlist()) {
    console.log(" track already in playlist ");
  }

  add_track_to_playlist({
    user_id: open_playlist_userid,
    playlist_id: open_playlist_id,
    uri: 'spotify:track:' + track_html.attributes['data-track-id'].value
  }, token);
}

const update_album_tracks = function (album_tracks) {
  album_tracks_placeholder.innerHTML = album_tracks_template(album_tracks);
}


const show_album_tracks = function (album_html) {
  $("#track-results").hide()
  $("#artist-results").hide()
  $("#album-results").hide()


  var album = {
    album_id: album_html.attributes['data-album-id'].value,
    album_image_url: album_html.attributes['data-album-image-url'].value,
    album_artist: album_html.attributes['data-album-artist'].value,
    album_name: album_html.attributes['data-album-name'].value,
  };

  get_tracks_by_album(album, token)
}


const search_spotify = function (query, token) {
  var endpoint = 'https://api.spotify.com/v1/search';

  $.ajax({
      url: endpoint,
      data: {
          q: query,
          type: 'album,track,artist'
      },
      type: "GET",
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', 'Authorization: Bearer '+ token);
      },
      success: function (response) {
          artistResultsPlaceholder.innerHTML = artistTemplate(response.artists);
          albumsResultsPlaceholder.innerHTML = albumTemplate(response.albums);
          tracksResultsPlaceholder.innerHTML = trackTemplate(response.tracks);
      }
  });
}


const exit_album_view = function () {
  $("#track-results").show();
  $("#artist-results").show();
  $("#album-results").show();
  album_tracks_placeholder.innerHTML = '';
}


const reset_results =  function () {
  artistResultsPlaceholder.innerHTML = '';
  albumsResultsPlaceholder.innerHTML = '';
  tracksResultsPlaceholder.innerHTML = '';
  album_tracks_placeholder.innerHTML = '';
}


const get_playlist_data = function (data, token) {

  var endpoint = 'https://api.spotify.com/v1/users/' + data.user_id + '/playlists/' + data.playlist_id;

  $.ajax({
    url: endpoint,
    beforeSend: function(xhr){
      xhr.setRequestHeader('Authorization', 'Authorization: Bearer '+ token);
    },
    success: function (response) {
      update_playlist_data(response);
    }
  });
}


const update_playlist_data = function (data) {
  console.log( data.tracks );

  for(var i=0; i<data.tracks.length; i++){
    console.log(data.tracks[i]);
  }

  playlist_placeholder.innerHTML = playlist_template({
    description : data.description,
    followers   : data.followers.total,
    url         : data.external_urls.spotify,
    id          : data.id,
    owner       : data.owner,
    images      : data.images,
    name        : data.name,
    snapshot_id : data.snapshot_id,
    tracks      : data.tracks
  });
}

const get_current_playback = function () {

  var endpoint = 'https://api.spotify.com/v1/me/player/currently-playing';
  $.ajax({
    type: "GET",
    url: endpoint,
    beforeSend: function(xhr){
      xhr.setRequestHeader('Authorization', 'Authorization: Bearer '+ token);
    },
    success: function (response) {
      console.log('response', response);
    }
  });
}


const get_recent_tracks = function () {

  var endpoint = 'https://api.spotify.com/v1/me/player/recently-played';
  $.ajax({
    type: "GET",
    url: endpoint,
    beforeSend: function(xhr){
      xhr.setRequestHeader('Authorization', 'Authorization: Bearer '+ token);
    },
    success: function (response) {
      console.log('response', response);
    }
  });
}


/**
 *  get_tracks_by_album
 *  Return a list of tracks from an album id
 *  @endpoint https://api.spotify.com/v1/albums/{id}/tracks
 *  @documentation https://beta.developer.spotify.com/console/get-album-tracks
 */
const get_tracks_by_album = function (album, token) {

  var endpoint = 'https://api.spotify.com/v1/albums/' + album.album_id + '/tracks';

  $.ajax({
    url: endpoint,
    beforeSend: function(xhr){
      xhr.setRequestHeader('Authorization', 'Authorization: Bearer '+ token);
    },
    success: function (response) {
      console.log('response', response);
      album.items = response.items;
      update_album_tracks(album);
    }
  });
}
