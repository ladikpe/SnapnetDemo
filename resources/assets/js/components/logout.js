import React from "react";
import { GoogleLogout } from "react-google-login";

const clientId = process.env.REACT_APP_GOOGLE_CLIENT_ID;

function LogoutButton() {
  const onSuccess = () => {
    console.Console.log("Log out successful");
  };
  return (
    <div id="signOutButton">
      <GoogleLogout clientId={clientId} buttonText={"Logout"} onLogoutSuccess={onSuccess} />
    </div>
  );
}

export default LogoutButton;
