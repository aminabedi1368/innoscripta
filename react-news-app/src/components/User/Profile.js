import React, {useEffect, useRef, useState} from "react";
import AuthService from "./services/auth.service";
import {PROFILE} from "./index";
import Form from "react-validation/build/form";
import Input from "react-validation/build/input";
import CheckButton from "react-validation/build/button";

const Profile = () => {

    const [currentUser, setCurrentUser] = useState(AuthService.getCurrentUser());
    const [avatarURL, setAvatarURL] = useState(currentUser.profile.avatar);

    useEffect(() => {
        const handleOutsideClick = (e) => {
            if (popupRef.current && !popupRef.current.contains(e.target)) {
                setShowPopup(false);
            }
        };

        document.addEventListener("click", handleOutsideClick);

        return () => {
            document.removeEventListener("click", handleOutsideClick);
        };
    }, []);

    const handleProfileImageClick = (e) => {
        e.stopPropagation();
        setShowPopup(true);
    };

    useEffect(() => {
        // Call the AuthService.getProfile() function to fetch the user profile
        AuthService.getProfile().then(
            (user) => {
                setCurrentUser(user);
                setAvatarURL(user.profile.avatar || null);
            },
            (error) => {
                console.error("Error fetching user profile:", error);
            }
        );
    }, []);

    const form = useRef();
    const checkBtn = useRef();
    const popupRef = useRef();


    const [showPopup, setShowPopup] = useState(false);
    const [dragActive, setDragActive] = React.useState(false);

    const handleDrag = function(e) {
        e.preventDefault();
        e.stopPropagation();
        if (e.type === "dragenter" || e.type === "dragover") {
            setDragActive(true);
        } else if (e.type === "dragleave") {
            setDragActive(false);
        }
    };

    const handleDrop = function(e) {
        e.preventDefault();
        e.stopPropagation();
        setDragActive(false);
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            const file = e.dataTransfer.files[0];
            setSelectedImage(file);
        }
    };

    const [successful, setSuccessful] = useState(false);
    const [message, setMessage] = useState("");

    const [new_password, setNew_password] = useState("");
    const [old_password, setOld_password] = useState("");

    const [selectedImage, setSelectedImage] = useState(null);
    const onChangeOld_password = (e) => {
        const old_password = e.target.value;
        setOld_password(old_password);
    };
    const onChangeNew_password = (e) => {
        const new_password = e.target.value;
        setNew_password(new_password);
    };

    const handleChangePassword = (e) => {
        e.preventDefault();
        AuthService.updatePassWithInterceptors(old_password, new_password).then(
            (response) => {
                setMessage(" verify successfully");
                setSuccessful(true);
            },
            (error) => {
                console.log("error", error);
                const resMessage =
                    (error.response &&
                        error.response.data &&
                        error.response.data.message) ||
                    error.message ||
                    error.toString();
                setMessage(resMessage);
                setSuccessful(false);
            }
        );
    };

    const handleImageChange = (e) => {
        if (e.target.files && e.target.files[0]) {

            const file = e.target.files[0];
            setSelectedImage(file);
        }
    };

    const handleUpdateAvatar = (e) => {
        if(e){
            e.preventDefault();
        }
        if (selectedImage) {
            AuthService.UploadAvatar(selectedImage).then(
                (response) => {
                    setAvatarURL(response.avatar);
                },
                (error) => {
                    const resMessage =
                        (error.response &&
                            error.response.data &&
                            error.response.data.message) ||
                        error.message ||
                        error.toString();
                    setMessage(resMessage);
                    setSuccessful(false);
                }
            );
            // Close the popup
            setShowPopup(false);
        }

    };


    return (
        <>
            <PROFILE>
                <div className="container col-md-12 flex">
                    <div className="col-md-4">
                        <header className="jumbotron">
                            <div className="profile-img-container"  onClick={() => setShowPopup(true)}>
                                <img onClick={handleProfileImageClick}
                                    src={
                                        currentUser.profile.avatar
                                            ? "http://88.198.55.85:8094/" + avatarURL
                                            : "//ssl.gstatic.com/accounts/ui/avatar_2x.png"
                                    }
                                    alt="profile-img"
                                    className="profile-img-card"
                                />
                            </div>
                            {showPopup && (
                                <div className="popup-card" ref={popupRef}>
                                    <h2>Update Avatar</h2>
                                    <div className="update-avatar-popup">
                                        <form id="form-file-upload" onDragEnter={handleDrag} onSubmit={(e) => e.preventDefault()}>
                                            <input type="file" accept="image/*" id="input-file-upload" onChange={handleImageChange} multiple={false} />
                                            <label id="label-file-upload" htmlFor="input-file-upload">
                                                <div>
                                                    <p>Drag and drop your avatar here or</p>
                                                    <button onClick={handleUpdateAvatar} className="upload-button">Upload a Avatar</button>
                                                </div>
                                            </label>
                                            { dragActive && <div id="drag-file-element" onDragEnter={handleDrag} onDragLeave={handleDrag} onDragOver={handleDrag} onDrop={handleDrop}></div> }
                                        </form>
                                        {/*<input type="file" accept="image/*" onChange={handleImageChange}/>*/}
                                        {/*<button onClick={handleUpdateAvatar}>Update Avatar</button>*/}
                                        {/*<button onClick={() => setShowPopup(false)}>Cancel</button>*/}
                                    </div>
                                </div>
                            )}
                            <h3>
                                <strong>{currentUser.profile.first_name} {currentUser.profile.last_name}</strong> Profile
                            </h3>
                            <p>
                                <strong>Id:</strong> {currentUser.profile.id}
                            </p>
                            <p>
                                <strong>User
                                    Identifiers:</strong> {currentUser.user_identifiers.map(item => item.value).join(", ")}
                            </p>
                            <strong>Authorities:</strong>
                            <ul>
                                {currentUser.roles &&
                                    currentUser.roles.map((role, index) => <li key={index}>{role.name}</li>)}
                            </ul>
                        </header>

                    </div>
                    <div className="col-md-8">

                        <header className="jumbotron">
                            <h3>
                                <strong> Update Profile</strong>
                            </h3>

                            <Form onSubmit={handleChangePassword} ref={form}>
                                {!successful && (
                                    <div>
                                        <div className="form-group">
                                            <label htmlFor="username">Old Password</label>
                                            <Input
                                                type="text"
                                                className="form-control"
                                                name="old_password"
                                                value={old_password}
                                                onChange={onChangeOld_password}
                                            />
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="username">New Password</label>
                                            <Input
                                                type="text"
                                                className="form-control"
                                                name="new_password"
                                                value={new_password}
                                                onChange={onChangeNew_password}
                                            />
                                        </div>

                                        <div className="form-group">
                                            <button className="btn btn-primary btn-block">Update password</button>
                                        </div>
                                    </div>
                                )}

                                {message && (
                                    <div className="form-group">
                                        <div
                                            className={
                                                successful ? "alert alert-success" : "alert alert-danger"
                                            }
                                            role="alert">
                                            {message}
                                        </div>


                                    </div>
                                )}
                                <CheckButton style={{display: "none"}} ref={checkBtn}/>
                            </Form>

                        </header>

                    </div>
                </div>


            </PROFILE>
        </>
    );
};

export default Profile;
