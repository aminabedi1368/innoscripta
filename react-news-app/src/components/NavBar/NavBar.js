import React, {useRef, useState} from "react";
import {v4 as uuidv4} from "uuid";
import {btnColor, formInput, nav, navBar, navBrand, searchForm,} from "./index";
import {Button, Form, FormControl, Nav, Navbar} from "react-bootstrap";
import {navbarBrand, navs} from "../../config/config";
import {LinkContainer} from "react-router-bootstrap";
import {useNavigate} from "react-router-dom";
import News from "../News/News";
import AuthService from "../User/services/auth.service";
import api from "../User/services/Api";

function NavBar(props) {
  const navigate = useNavigate();
  const navRef = useRef(null);

  const [searchQuery, setSearchQuery] = useState("");
  const [searchSearch, setSearchSearch] = useState("");
  const [articles, setArticles] = useState(null);
  const [loading, setLoading] = useState(false);
  const [isCollapsed, setIsCollapsed] = useState(true);
  const [showSearchResults, setShowSearchResults] = useState(false);

  const handleSearch = async () => {
    try {
      props.setProgress(15);
      setIsCollapsed(true);
      setLoading(true);
      if(AuthService.logined()){
        const response = await api.get("users/fetch-news?category="+searchQuery).then((response) => {
          return response.data;
        });
        console.log(response);
        props.setProgress(70);
        setSearchSearch(searchQuery);
        setArticles(response);
        setSearchQuery("");
        setShowSearchResults(true);
        setLoading(false);
        navigate("/search?query="+searchQuery);
        props.setProgress(100);
      }else {
        const response = await api.get("news?category="+searchQuery).then((response) => {
          return response.data;
        });
        props.setProgress(70);
        setSearchSearch(searchQuery);
        setArticles(response.data);
        setSearchQuery("");
        setShowSearchResults(true);
        setLoading(false);
        navigate("/search?query="+searchQuery);
        props.setProgress(100);
      }

    } catch (error) {
      console.error(error);
    }
  };

  const handleInputChange = (event) => {
    event.preventDefault();
    setSearchQuery(event.target.value);
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    setIsCollapsed(true);
    handleSearch();
  };

  const handleNavClick = () => {
    setIsCollapsed(true);
    setShowSearchResults(false);
  };
  const logout = () => {
    AuthService.logout().then(() => {
      navigate("/"); // Redirect to the home page after logout
    });
  };
  const isSearchButtonDisabled = searchQuery.trim() === "";
  let filteredNavs=navs;
  const accessToken = localStorage.getItem('access_token');
    if(accessToken === null){
      filteredNavs = navs.filter(
          (navItem) => navItem.nav !== 'Profile' && navItem.nav !== 'Logout'
      );
    }

  return (
      <>
        <Navbar
            ref={navRef}
            style={navBar}
            variant="dark"
            expand="lg"
            fixed="top"
            expanded={!isCollapsed}
        >
        <Navbar.Brand style={navBrand} href="/">
          {navbarBrand}
        </Navbar.Brand>
        <Navbar.Toggle
          className="border-0"
          aria-controls="basic-navbar-nav"
          onClick={() => setIsCollapsed(!isCollapsed)}
        />
        <Navbar.Collapse id="basic-navbar-nav">

          <Nav style={nav} className="mr-auto" onClick={handleNavClick}>
            {filteredNavs.map((navItem) => (
                (navItem.nav === "Logout" && accessToken) ? (
                        <LinkContainer to={navItem.page} key={uuidv4()}>
                          <Nav.Link className="ml-2"><span onClick={() => logout(navItem)}>
                              {navItem.nav}
                            </span></Nav.Link>
                        </LinkContainer>
                    ) :
                    (navItem.nav === "Profile" && accessToken) ? (
                        <LinkContainer to={navItem.page} key={uuidv4()}>
                          <Nav.Link className="ml-2">{navItem.nav}</Nav.Link>
                        </LinkContainer>
                    ) : (
                        (navItem.nav === "Login" || navItem.nav === "Register") && accessToken ? null : (
                            <LinkContainer to={navItem.page} key={uuidv4()}>
                              <Nav.Link className="ml-2">{navItem.nav}</Nav.Link>
                            </LinkContainer>
                        )
                    )
            ))}
          </Nav>

          <Form style={searchForm} onSubmit={handleSubmit}>
            <FormControl
              type="text"
              placeholder="Explore news..."
              style={formInput}
              className="form-control-lg bg-dark mt-lg-2 mt-md-2 mt-sm-2 mt-xl-0 text-white shadow-sm border-dark"
              value={searchQuery}
              onChange={handleInputChange}
            />
            <Button
              className="btn custom-btn mt-lg-2 ml-2 mt-md-2 mt-sm-2 mt-xl-0 shadow-sm"
              style={btnColor}
              onClick={handleSearch}
              disabled={isSearchButtonDisabled}
            >
              Search
            </Button>
          </Form>
        </Navbar.Collapse>
      </Navbar>
      {showSearchResults ? (
        <News news={articles} searchQuery={searchSearch} loading={loading} />
      ) : null}
    </>
  );
}

export default NavBar;
