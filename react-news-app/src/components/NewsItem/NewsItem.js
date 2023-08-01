import React from "react";
import { Button, Card } from "react-bootstrap";
import Details from "./Details";
import { card, img, btn, txt } from "./index";

function NewsItem(props) {
  const {author, category, content, description, published_at, source, title, url, urlToImage} = props;
  return (
    <>
      <Card style={card}>
        <Card.Img style={img} variant="top" src={urlToImage} alt={urlToImage} />
        <Card.Body>
          <Card.Title>{title}</Card.Title>
          <Card.Text style={txt}>{description}</Card.Text>
          <Card.Text style={txt}>{content}</Card.Text>
          <Card.Text style={txt}>{content}</Card.Text>
          <Card.Text style={txt}>category: {category}</Card.Text>

          <Card.Text style={txt}>Author: {author}</Card.Text>


          <Details channel={source} published={published_at} />

          <Button href={url} target="_blank" style={btn}>
            Read more →
          </Button>
        </Card.Body>
      </Card>
    </>
  );
}

export default NewsItem;

