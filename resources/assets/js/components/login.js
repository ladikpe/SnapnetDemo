import React from "react";
import { GoogleLogin } from "react-google-login";

const clientId = process.env.REACT_APP_GOOGLE_CLIENT_ID;

const LoginButton = ({ start }) => {

  const onSuccess = (res) => {
    start();
    console.log("LOGIN SUCCESS! Current user", res.profileObj);
  };

  const onFailure = (res) => {
    console.log("LOGIN FAILED!", res);
  };
  return (
    <div id="signInButton">
      <GoogleLogin clientId={clientId} buttonText="Login" onSuccess={onSuccess} onFailure={onFailure} cookiePolicy={"single_host_origin"} isSignedIn={true} />
    </div>
  );
};

export default LoginButton;
