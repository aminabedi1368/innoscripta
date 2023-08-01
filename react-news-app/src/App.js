import React, { useState } from "react";

import { v4 as uuidv4 } from "uuid";
import NavBar from "./components/NavBar/NavBar";
import News from "./components/News/News";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import { router } from "./config/config";
import LoadingBar from "react-top-loading-bar";
import Login from "./components/User/Login";
import Register from "./components/User/Register";
import Profile from "./components/User/Profile";
import Advanced from "./components/User/Advanced";
function App() {
  const [progress, setProgress] = useState(0);
  document.body.style.backgroundColor = "rgb(36, 39, 41)";

  return (
    <>
      <Router>
        <NavBar setProgress={setProgress}/>
        <LoadingBar color="#005abb" height={3} progress={progress} />
        <Routes>
          {
            router.map(path =>
            <Route
                exact
                key={uuidv4()}
                path={path.path}
                element={
                  <News
                    setProgress={setProgress}
                    key={path.key}
                    category={path.category}
                  />
                }
              />
            )
          }
          <Route exact path="/login" element={<Login />} />
          <Route exact path="/register" element={<Register />} />
          <Route exact path="/profile" element={<Profile />} />
          <Route exact path="/advanced" element={<Advanced />} />

          <Route exact path="/search" element={<News
              setProgress={setProgress}
              key={'search'}
              category={'general'}
          />} />
        </Routes>

      </Router>
    </>
  );
}

export default App;
