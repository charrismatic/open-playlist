var express = require('express');
var request = require('request');
var env = require('dotenv').config().parsed;

var app = express();

const LISTEN_PORT = 8888;

var credentials = null;

const get_authorization = (client_id, client_secret) => {
  const authorization_string = (new Buffer(`${client_id}:${client_secret}`).toString('base64'));
  var authOptions = {
    url: 'https://accounts.spotify.com/api/token',
    headers: {
      'Authorization': `Basic ${authorization_string}`
    },
    form: {
      grant_type: 'client_credentials'
    },
    json: true
  };
  request.post(authOptions, function(error, response, body) {
    if (!error && response.statusCode === 200) {
      credentials = body
      console.log(credentials);
    } else {
      console.log('auth failed',body);
    }
  });
}

get_authorization(env.client_id, env.client_secret);

app.get('/token', function(req, res) {
  if (credentials.access_token) {
    res.send(credentials.access_token);
  } else {
    get_authorization();
    res.send('There was a problem, please try again in a few minutes');
  }
});


app.get('/refresh-token', function(req, res) {
  // requesting access token from refresh token
  console.log(req.query)

  var refresh_token = req.query.refresh_token
  var authorization_string = Buffer.from(env.client_id + ':' + env.client_secret).toString('base64')

var auth_options = {
    url: 'https://accounts.spotify.com/api/token',
    headers: {
      'Authorization': `Basic ${authorization_string}`
    },
    form: {
      grant_type: 'refresh_token',
      refresh_token: env.refresh_token
    },
    json: true
  }
// refresh_token: refresh_token

  request.post(auth_options, function(error, response, body) {
    if (!error && response.statusCode === 200) {
      var access_token = body.access_token
      credentials = body
      res.send({
        'access_token': access_token
      })
    } else {
      console.log(response)
      console.log(error)
      res.send({
        'error': error
      })
    }
  })
})

app.use(express.static(__dirname + '/public'));

console.log(`Listening on ${LISTEN_PORT}`);

app.listen(LISTEN_PORT);
