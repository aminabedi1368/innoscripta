import React, {useEffect, useRef, useState} from "react";
import AuthService from "./services/auth.service";
import {ADVANCED} from "./index";
import Form from "react-validation/build/form";
import Input from "react-validation/build/input";
import News from "../News/News";

const Advanced = () => {


    const [hisotrySearch, sethisotrySearch] = useState('');
    const [currentPage, setCurrentPage] = useState(0);
    const [subject, setSubject] = useState('');
    const [source, setSource] = useState('');
    const [pageSize, setPageSize] = useState(100);
    const [loading, setLoading] = useState(false);
    const [newsData, setNewsData] = useState(null);
    const resultSearchRef = useRef(null); // Ref for the result_search element

    useEffect(() => {
        // Call the AuthService.getProfile() function to fetch the user profile
        AuthService.getHistoryWithInterceptors().then(
            (history) => {
                sethisotrySearch(history);
                setCurrentPage(parseInt(history.current_page, 10))
            },
            (error) => {
                console.error("Error fetching user profile:", error);
            }
        );
    }, []);

    const form = useRef();
    const onChangeSubject = (e) => {
        const subject = e.target.value;
        setSubject(subject);
    };
    const onChangePageSize = (e) => {
        const pageSize = e.target.value;
        setPageSize(pageSize);
    };

    const onChangeSource = (e) => {
        const source = e.target.value;
        setSource(source);
    };

    const handlePageClick = (pageNumber) => {
        AuthService.getHistoryWithInterceptors(null, null, null, pageNumber).then(
            (history) => {
                sethisotrySearch(history);
                setCurrentPage(parseInt(history.current_page, 10))
            },
            (error) => {
                console.error("Error fetching user profile:", error);
            }
        );
    };

    const handleHistoryFilter = (timeFilter) => {
        AuthService.getHistoryWithInterceptors(null, timeFilter, null, null).then(
            (history) => {
                sethisotrySearch(history);
                setCurrentPage(parseInt(history.current_page, 10))
            },
            (error) => {
                console.error("Error fetching user profile:", error);
            }
        );
    };
    const handleAdvanceSearch = (e) => {
        e.preventDefault();
        AuthService.AdvancedSearchWithInterceptors(source, subject, pageSize).then(
            (advanced) => {
                setNewsData(advanced);
                setLoading(false);
                scrollToResultSearch();

            },
            (error) => {
                console.error("Error fetching user profile:", error);
            }
        );
    };
    const scrollToResultSearch = () => {
        if (resultSearchRef.current) {
            resultSearchRef.current.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
        }
    };

    return (
        <>
            <ADVANCED>
                <div className="container col-md-12">
                    <div className="col-md-4">
                        <header className="jumbotron">
                            <h3>
                                <strong> All your History Search</strong>
                            </h3>
                            <div className="filterTime col-md-12">
                                <div className="row"> you can filter your time:  </div>
                                <span className="col-md-3 p-1 m-1" onClick={() => handleHistoryFilter('today')}> <svg
                                    fill="#000000" width="16px" height="16px" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g data-name="Layer 2">
                                    <g data-name="arrow-ios-forward">
                                    <rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"/>
                                    <path
                                        d="M10 19a1 1 0 0 1-.64-.23 1 1 0 0 1-.13-1.41L13.71 12 9.39 6.63a1 1 0 0 1 .15-1.41 1 1 0 0 1 1.46.15l4.83 6a1 1 0 0 1 0 1.27l-5 6A1 1 0 0 1 10 19z"/>
                                    </g>
                                    </g>
                                    </svg>
                                    today</span>
                                <span className="col-md-4 p-1 m-1" onClick={() => handleHistoryFilter('week')}> <svg
                                    fill="#000000" width="16px" height="16px" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g data-name="Layer 2">
                                    <g data-name="arrow-ios-forward">
                                    <rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"/>
                                    <path
                                        d="M10 19a1 1 0 0 1-.64-.23 1 1 0 0 1-.13-1.41L13.71 12 9.39 6.63a1 1 0 0 1 .15-1.41 1 1 0 0 1 1.46.15l4.83 6a1 1 0 0 1 0 1.27l-5 6A1 1 0 0 1 10 19z"/>
                                    </g>
                                    </g>
                                    </svg>
                                    this week</span>
                                    <span className="col-md-4 p-1 m-1" onClick={() => handleHistoryFilter('month')}> <svg
                                    fill="#000000" width="16px" height="16px" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g data-name="Layer 2">
                                    <g data-name="arrow-ios-forward">
                                    <rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"/>
                                    <path
                                        d="M10 19a1 1 0 0 1-.64-.23 1 1 0 0 1-.13-1.41L13.71 12 9.39 6.63a1 1 0 0 1 .15-1.41 1 1 0 0 1 1.46.15l4.83 6a1 1 0 0 1 0 1.27l-5 6A1 1 0 0 1 10 19z"/>
                                    </g>
                                    </g>
                                    </svg>
                                    this month</span>
                            </div>
                            <ul>
                                {hisotrySearch &&
                                    hisotrySearch.data.map((article, index) =>
                                        <li key={index}>
                                            <a href={article.url} target="_blank" rel="noopener noreferrer">
                                                {article.title}
                                            </a>
                                        </li>)}
                            </ul>
                            {hisotrySearch && hisotrySearch.data.length > 0 &&
                                <div className="pagination">
                                    {currentPage > 1 && (
                                        <div>
                                            <button
                                                className="pagination_button"
                                                type="button"
                                                onClick={() => handlePageClick(currentPage - 1)}
                                            >
                                                {currentPage - 1}
                                            </button>
                                        </div>
                                    )}
                                    <div className="pagination_button">
                                        {currentPage}
                                    </div>
                                    <div>
                                        <button
                                            className="pagination_button"
                                            type="button"
                                            onClick={() => handlePageClick(currentPage + 1)}
                                        >
                                            {currentPage + 1}
                                        </button>
                                    </div>

                                    <div>
                                        <button
                                            className="pagination_button"
                                            type="button"
                                            onClick={() => handlePageClick(hisotrySearch.last_page)}
                                        >
                                            {hisotrySearch.last_page}
                                        </button>
                                    </div>
                                    <div className="pagination_button">
                                        {hisotrySearch.total}
                                    </div>

                                </div>
                            }
                        </header>

                    </div>
                    <div className="col-md-8">
                        <header className="jumbotron">
                            <h3>
                                <strong> Advance Search</strong>
                            </h3>

                            <Form onSubmit={handleAdvanceSearch} ref={form}>
                                <div>
                                    <div className="form-group">
                                        <select
                                            className="form-control"
                                            value={source}
                                            onChange={onChangeSource}
                                        >
                                            <option value="">Select Source</option>
                                            <option value="bbcNews">BBC News</option>
                                            <option value="TheGuardian">The Guardian</option>
                                            <option value="NewYorkTimes">NewYork Times</option>
                                            <option value="All">All</option>
                                        </select>
                                    </div>

                                    <div className="form-group">
                                        <Input
                                            type="text"
                                            className="form-control"
                                            placeholder="subject"
                                            name="subject"
                                            value={subject}
                                            onChange={onChangeSubject}
                                        />
                                    </div>

                                    <div className="form-group">
                                        <input
                                            type="number" // Use input type "number" for numeric input
                                            className="form-control"
                                            placeholder="page size number"
                                            name="numberInput"
                                            value={pageSize}
                                            onChange={onChangePageSize}
                                        />
                                    </div>

                                    <div className="form-group">
                                        <button className="btn btn-primary btn-block">Search</button>
                                    </div>
                                </div>
                            </Form>

                        </header>
                    </div>
                </div>

                <div id="result_search" ref={resultSearchRef}></div>
                {loading ? (
                    <div className="container col-md-12">

                        <div>Loading...</div>
                    </div>

                ) : (
                    newsData && (
                        <div className="col-md-12">
                            <News news={newsData} searchQuery={source} loading={0}/>
                        </div>

                    )
                )}
            </ADVANCED>
        </>
    );
};

export default Advanced;
