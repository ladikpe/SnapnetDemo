import React, { Component, useState } from "react";
import ReactDOM from "react-dom";
import { Route } from "react-router";

import { useLocation } from "react-router-dom";

import { useEffect } from "react";
import LoginButton from "./login";
import LogoutButton from "./logout";
import { gapi } from "gapi-script";
import { BrowserRouter } from "react-router-dom/cjs/react-router-dom.min";
import { split } from "lodash";

const cors = require("cors");



// const CLIENT_ID = "467096738315-fcib5m79sq62m507eaqmpm6iklsmjoia.apps.googleusercontent.com";
// const API_KEY = "AIzaSyAx2Fg9MneZMwW9-86kthfpFGr1x4suXO4";
// const SCOPES = "https://www.googleapis.com/auth/drive";



// REACT_APP_GOOGLE_CLIENT_ID=604251186965-ij4j9foa5ggcg1q65tuf8il6oe0ofbfu.apps.googleusercontent.com
// REACT_APP_GOOGLE_API_KEY=AIzaSyBkf17HQ2x4B7QE6e-zc__ukYATuexlp6U
// REACT_APP_GOOGLE_SCOPES=https://www.googleapis.com/auth/drive

const CLIENT_ID = process.env.REACT_APP_GOOGLE_CLIENT_ID;
const API_KEY = process.env.REACT_APP_GOOGLE_API_KEY;
const SCOPES = process.env.REACT_APP_GOOGLE_SCOPES;

// const app;
// app.use((req, res, next) =>
// {
//   res.setHeader('Access-Control-Allow-Origin', '*');
//   res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE');
//   res.setHeader("Access-Control-Allow-Headers", "Content-Type", 'Authorization');
//   next();
// });

// app.use(cors());

export default function Example() {

  const location = useLocation();
  const path = location.pathname;
  const pathArray = split(path, "/");
  //console.log(pathArray);

  const [tag, setTag] = useState('');
  const [isCreated, setIsCreated] = useState(false);

  // function isCreatedHandler() {
  //   localStorage.setItem('isCreated', true);
  //   setIsCreated(!isCreated);
  // }

  // function checkIfIsCreatedInStorage() {
  //   let createdCheck = localStorage.getItem('isCreated');
  //   if (createdCheck) {
  //     setIsCreated(true);
  //   }

  // }

  const [googleDocId, setgoogleDocId] = useState("");
  function start() {
    gapi.client.init(
      {
        apiKey: API_KEY,
        clientId: CLIENT_ID,
        scope: SCOPES,
      });
  }

  useEffect(() => {
    // checkIfIsCreatedInStorage();
    getTaskName(pathArray[2]);
    gapi.load('client:auth2', start);

  }, []);



  function zeroFill(i) {
    return (i < 10 ? "0" : "") + i; // 10
  }

  function getDateString() {
    const date = new Date();
    const year = date.getFullYear();
    const month = zeroFill(date.getMonth() + 1);
    const day = zeroFill(date.getDate());
    return year + "_" + month + "_" + day;
  }

  function getTimeString() {
    const date = new Date();
    return date.toLocaleTimeString();
  }

  function updateDocumentId(id, docId) {
    fetch(updateDocId,
      {
        method: "POST",
        headers: { "content-type": "application/json" },
        body: JSON.stringify({ id: id, google_doc_id: docId, _token: _token }),
      }).then((res) => {
        return res;
      });
  }


  async function getTaskName(pathArray) {
    const resp = await fetch("/get-task-by-id/" + pathArray, {
      method: "GET",
      // headers: new Headers({ Authorization: "Bearer " + accessToken }),
    }).then((res) => {
      return res.json();
    });
    console.log(resp);
    if (resp.google_doc_id !== null) {
      setIsCreated(!isCreated);
    }
    const { name } = resp;

    setTag(name);
  }



  async function getTaskGoogleId(pathArray) {
    // return alert(getTaskGoogleId(pathArray));
    return fetch("/get-task-google-id/" + pathArray, {
      method: "GET",
      // headers: new Headers({ Authorization: "Bearer " + accessToken }),
    }).then(async (res) => {
      const google_doc_id = await res.json();
      // alert((await res.json()));
      //return;
      setTag(google_doc_id);
      return Promise.resolve(google_doc_id);
    });
    console.log('This is the Response : ' + resp);
  }




  function createFile(tag) {
    var accessToken = gapi.auth.getToken().access_token;
    var fileName = tag + " : " + getDateString() + " " + getTimeString();
    fetch("https://docs.googleapis.com/v1/documents?title=" + fileName, {
      method: "POST",
      headers: new Headers({ Authorization: "Bearer " + accessToken }),
    })
      .then((res) => {
        return res.json();
      })

      .then(function (val) {
        console.log("The Created documentId", val.documentId);
        setgoogleDocId(val.documentId)
        var idd = pathArray[2];
        updateDocumentId(idd, val.documentId);
        getTaskName(val.documentId);
        window.open("https://docs.google.com/document/d/" + val.documentId + "/edit", "_black");

        setIsCreated(!isCreated);
        // console.log(val.documentId)
      });
    console.log(`Tag: ${tag}`);
  }



  async function editFile(tag) {
    var gid = await getTaskGoogleId(pathArray[2]);
    // getTaskName(pathArray[2]);
    // return getTaskName(pathArray[2]);
    var accessToken = gapi.auth.getToken().access_token;
    var documentId = gid;          //"1S3wA-Gb6EUFbyqRw3KZwGJ6HsH0qqWKjgepxZCE5fws";
    window.open("https://docs.google.com/document/d/" + documentId + "/edit", "_black");
  }


  return (
    // <Route path="google-react/:id">

    <div className="container" style={{ width: '100%' }}>
      <div className="row justify-content-center">
        <div className="col-md-8">
          <div className="card">
            <div className="card-header d-flex justify-content-center" style={{ backgroundColor: '#eee', fontSize: '16px' }} id="title">Create New Document Using Google Account</div>
            <div className="row mt-3 mb-3">
              <div className="col-md-6 pull-left d-flex justify-content-center"> <LoginButton start={start} /> </div>
              <div className="col-md-6 pull-left d-flex justify-content-center"> <LogoutButton /> </div>
            </div>

            {!isCreated ? <button className="btn btn-info mt-1 mb-1" style={{ cursor: 'pointer', width: '50%', margin: 'auto' }} onClick={() => createFile(tag)}>Create Document</button>
              :
              <button className="btn btn-info mt-1 mb-1" style={{ cursor: 'pointer', width: '50%', margin: 'auto' }} onClick={() => editFile(tag)}>Edit Document</button>}

            {/* <div className="card-body">I'm an example component!!</div> */}
          </div>
        </div>
      </div>
    </div>

    // </Route>
  );
}

if (document.getElementById("app")) {
  ReactDOM.render(
    <BrowserRouter>
      <Example />
    </BrowserRouter>,
    document.getElementById("app")
  );
}
