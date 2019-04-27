<!-- PLAYLIST TEMPLATE -->
<script id="playlist-template" type="text/x-handlebars-template">

  <div class="playlist" data-playlist-id="{{id}}" data-playlist-snapshot="{{snapshot_id}}">
  <h2 class="playlist__title">{{name}}</h2>
  <!-- <h3 class="playlist__description">{{description}}</h3> -->
  <div class="playlist__meta">
    <span class="playlist__followers">Followers: {{followers}}</span>
    <!-- https://developer.spotify.com/web-api/follow-playlist/ -->
    <button id="follow-playlist" data-playlist-id="{{id}}" class="spot_button">Follow Playlist</button>
    <p><a href="{{url}}">Spotify Link</a></p>
    <p><a href="spotify:user:{{owner.id}}:playlist:{{id}}">Spotify URI</a></p>
  </div>
  <div class="playlist__image" style="background-image:url({{images.0.url}})"></div>
    <h3>Track List</h3>
    <ul>
      {{#each tracks.items}}
        <li class="track" data-track-id="{{track.id}}">{{track.name}} by {{track.artists.0.name}} <span class="track-added-at">{{ added_at }}</span></li>
      {{/each}}
      </ul>
    </div>
  </div>
</script>


<!-- ARTIST SEARCH RESULTS -->
<script id="artist-results-template" type="text/x-handlebars-template">
    <h2>Artists</h2>
    {{#each items}}
    <div style="" data-artist-id="{{id}}" data-artist-uri="{{uri}}" class="artist">{{popularity}} {{name}}</div>
    {{/each}}
</script>


<!-- ALBUM SEARCH RESULTS TEMPLATE -->
<script id="album-results-template" type="text/x-handlebars-template">
  <h2>Albums</h2>
  {{#each items}}
    <div class="cover"
      style="background-image:url({{images.0.url}})" 
      data-album-id="{{id}}" 
      data-album-image-url="{{images.0.url}}" 
      data-album-artist="{{artists.0.name}}"
      data-album-name="{{name}}" 
      onclick="show_album_tracks(this)">
    </div>
  {{/each}}
</script>


<!-- TRACK SEARCH RESULTS -->
<script id="track-results-template" type="text/x-handlebars-template">
  <h2>Tracks</h2>
  {{#each items}}
    <div class="track flex-row">
      <button class="spot_button add_track" data-track-id="{{id}}" onclick="handle_add_track(this)">Add Track</button><span class="track-name">{{name}}</span><span class="track-seperator"> by </span><span class="track-artist"> {{#each artists}} {{name}} {{/each}}</span>
    </div>
  {{/each}}
</script>


<!-- ALBUM TRACK LIST TEMPLATE -->
<script id="album-tracks-template" type="text/x-handlebars-template">
  <button onclick="exit_album_view()" class="spot_button">Back</button>
  
  <div class="album-details" 
    data-album-id="{{album_id}}" 
    data-album-artist="{{album_artist}}" 
    data-album-name="{{album_name}}">
    
    <div class="cover" style="background-image:url({{album_image_url}})"></div>
    <h2>{{album_name}}</h2>
    <h3>{{album_artist}}</h3>
    <ul>
    {{#each items}}
      <li data-track-id="{{id}}" class="track">{{name}}</li>
    {{/each}}
    </ul>
  </div>
</script>
