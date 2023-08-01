import React, {useRef, useState} from "react";
import Form from "react-validation/build/form";
import Input from "react-validation/build/input";
import CheckButton from "react-validation/build/button";
import {isEmail} from "validator";
import {useNavigate} from "react-router-dom";

import AuthService from "./services/auth.service";
import {REGISTER} from "./index";

const required = (value) => {
    if (!value) {
        return (
            <div className="invalid-feedback d-block">
                This field is required!
            </div>
        );
    }
};

const validEmail = (value) => {
    if (!isEmail(value)) {
        return (
            <div className="invalid-feedback d-block">
                This is not a valid email.
            </div>
        );
    }
};

const vLast_name = (value) => {
    if (value.length < 3 || value.length > 20) {
        return (
            <div className="invalid-feedback d-block">
                The Last name must be between 3 and 20 characters.
            </div>
        );
    }
};
const vFirst_name = (value) => {
    if (value.length < 3 || value.length > 20) {
        return (
            <div className="invalid-feedback d-block">
                The First name must be between 3 and 20 characters.
            </div>
        );
    }
};
const vpassword = (value) => {
    if (value.length < 6 || value.length > 40) {
        return (
            <div className="invalid-feedback d-block">
                The password must be between 6 and 40 characters.
            </div>
        );
    }
};
const vCode = (value) => {
    if (value.length < 5 || value.length > 6) {
        return (
            <div className="invalid-feedback d-block">
                The code must be 5 characters.
            </div>
        );
    }
};

const Register = (props) => {
    const navigate = useNavigate();
    const form = useRef();
    const verifyForm = useRef();
    const checkBtn = useRef();

    const [email, setEmail] = useState("");
    const [last_name, setLast_name] = useState("");
    const [first_name, setFirst_name] = useState("");
    const [password, setPassword] = useState("");
    const [successful, setSuccessful] = useState(false);
    const [message, setMessage] = useState("");
    const [Code, setCode] = useState("");


    const onChangeEmail = (e) => {
        const email = e.target.value;
        setEmail(email);
    };
    const onChangeFirst_name = (e) => {
        const first_name = e.target.value;
        setFirst_name(first_name);
    };
    const onChangeLast_name = (e) => {
        const last_name = e.target.value;
        setLast_name(last_name);
    };
    const onChangePassword = (e) => {
        const password = e.target.value;
        setPassword(password);
    };
    const onChangeCode = (e) => {
        const Code = e.target.value;
        setCode(Code);
    };
    const handleRegister = (e) => {
        e.preventDefault();

        setMessage("");
        setSuccessful(false);

        form.current.validateAll();

        if (checkBtn.current.context._errors.length === 0) {
            AuthService.register(first_name, last_name, email, password).then(
                (response) => {
                    setMessage("register success please verify your email");
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
        }
    };
    const handleVerify = (e) => {
        e.preventDefault();
console.log("handleVerify");
        AuthService.verify('email', email, Code).then(
            (response) => {
                setMessage(" verify successfully");
                setSuccessful(true);
                navigate("/login");

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

    return (
        <>
            <REGISTER>
                <div className="col-md-12">
                    <div className="card card-container">
                        <img
                            src="//ssl.gstatic.com/accounts/ui/avatar_2x.png"
                            alt="profile-img"
                            className="profile-img-card"
                        />

                        <Form onSubmit={handleRegister} ref={form}>
                            {!successful && (
                                <div>
                                    <div className="form-group">
                                        <label htmlFor="username">First name</label>
                                        <Input
                                            type="text"
                                            className="form-control"
                                            name="first_name"
                                            value={first_name}
                                            onChange={onChangeFirst_name}
                                            validations={[required, vFirst_name]}
                                        />
                                    </div>
                                    <div className="form-group">
                                        <label htmlFor="username">Last name</label>
                                        <Input
                                            type="text"
                                            className="form-control"
                                            name="last_name"
                                            value={last_name}
                                            onChange={onChangeLast_name}
                                            validations={[required, vLast_name]}
                                        />
                                    </div>
                                    <div className="form-group">
                                        <label htmlFor="email">Email</label>
                                        <Input
                                            type="text"
                                            className="form-control"
                                            name="email"
                                            value={email}
                                            onChange={onChangeEmail}
                                            validations={[required, validEmail]}
                                        />
                                    </div>

                                    <div className="form-group">
                                        <label htmlFor="password">Password</label>
                                        <Input
                                            type="password"
                                            className="form-control"
                                            name="password"
                                            value={password}
                                            onChange={onChangePassword}
                                            validations={[required, vpassword]}
                                        />
                                    </div>

                                    <div className="form-group">
                                        <button className="btn btn-primary btn-block">Sign Up</button>
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

                        {message && (
                            <Form onSubmit={handleVerify} ref={verifyForm}>
                                <div>
                                    <div className="form-group">
                                        <label htmlFor="Code">Code</label>
                                        <Input
                                            type="text"
                                            className="form-control"
                                            name="Code"
                                            value={Code}
                                            onChange={onChangeCode}
                                            validations={[required, vCode]}
                                        />
                                    </div>

                                    <div className="form-group">
                                        <button className="btn btn-primary btn-block">Verify</button>
                                    </div>
                                </div>
                            </Form>
                        )}

                    </div>
                </div>
            </REGISTER>
        </>
    );
};

export default Register;
