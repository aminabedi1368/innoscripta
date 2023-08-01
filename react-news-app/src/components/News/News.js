import React, {useEffect, useState} from "react";
import axios from "axios";
import NewsItem from "../NewsItem/NewsItem";
import Spinner from "../Spinner/Spinner";
import PropTypes from "prop-types";
import InfiniteScroll from "react-infinite-scroll-component";
import NullImage from "../../components/Images/nullimage.png";
import {v4 as uuidv4} from "uuid";
import {Col, Row} from "react-bootstrap";
import {card, Container, Header} from "./index";
import {endpointPath} from "../../config/api";
import {header} from "../../config/config";

function News(props) {
  const [articles, setArticles] = useState([]);
  const [loading, setLoading] = useState(true);
  const [totalArticles, setTotalArticle] = useState("");

  const capitaLize = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
  };

  const searchQuery = props.searchQuery;
  const category = props.category;
  const title = totalArticles === 0 ? "No Found" : searchQuery ? capitaLize(searchQuery) : capitaLize(category);
  document.title = `${capitaLize(title)} - News App`;

  const updatenews = async () => {
    try {
      props.setProgress(15);
      const response = await axios.get(
          endpointPath( props.category)
      );
      setLoading(true);
      props.setProgress(70);
      const parsedData = response.data;
      setArticles(parsedData.data);
      setLoading(false);
      props.setProgress(100);
    } catch (error) {
      console.error(error);
    }
  };

  useEffect(() => {
    if (props.news) {
      setArticles(props.news);
      setTotalArticle(props.news.length);
      setLoading(false);
    } else {
      updatenews();
    }
    // eslint-disable-next-line
  }, [props.news]);

  return (
    <>
      <Header>
        {totalArticles === 0
          ? "No Found"
          : header(
              searchQuery ? capitaLize(searchQuery) : capitaLize(category)
            )}
      </Header>
      {props.loading || loading ? <Spinner /> : null}
      <InfiniteScroll dataLength={articles.length} loader={<Spinner />}>
        <Container>
          <Row>
            {articles.map((element) => {
              return (
                <Col
                  sm={12}
                  md={6}
                  lg={4}
                  xl={3}
                  style={card}
                  key={uuidv4()}
                >
                  <NewsItem
                      author={element.author}
                      category={element.category}
                      content={element.content}
                      title={element.title}
                      description={element.description}
                      updated_at={element.updated_at}
                      source={element.source}
                      alt={element.alt}
                      published_at={element.published_at}
                      urlToImage={
                        element.urlToImage === null ? NullImage : element.urlToImage
                      }
                      url={element.url}
                  />
                </Col>
              );
            })}
          </Row>
        </Container>
      </InfiniteScroll>
    </>
  );
}

News.defaultProps = {
  category: "general",
};
News.propTypes = {
  category: PropTypes.string,
};

export default News;
