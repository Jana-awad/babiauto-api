const { google } = require("googleapis");
const keys = require("./serviceAccountKey.json");

async function getAccessToken() {
  const auth = new google.auth.GoogleAuth({
    credentials: keys,
    scopes: ["https://www.googleapis.com/auth/firebase.messaging"],
  });

  // Get a client
  const client = await auth.getClient();

  // Get access token
  const accessTokenResponse = await client.getAccessToken();

  console.log("Your FCM access token:");
  console.log(accessTokenResponse.token || accessTokenResponse);
}

getAccessToken().catch(console.error);
