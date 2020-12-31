var request = require('request');

module.exports = (req, res) => {
  var refresh_token = req.query.refresh_token
  var authorization_string = Buffer.from(process.env.client_id + ':' + process.env.client_secret).toString('base64')

  var auth_options = {
    url: 'https://accounts.spotify.com/api/token',
    headers: {
      'Authorization': `Basic ${authorization_string}`
    },
    form: {
      grant_type: 'refresh_token',
      refresh_token: process.env.refresh_token
    },
    json: true
  }
  // refresh_token: refresh_token

  request.post(auth_options, function(error, response, body) {
    if (!error && response.statusCode === 200) {
      var access_token = body.access_token
      credentials = body
      res.setHeader('Access-Control-Allow-Origin', '*')

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
}
