import styled from "styled-components";

export const LOGIN = styled.div`
  margin-top: 120px;
  font-size: unset;
`
export const REGISTER = styled.div`
  margin-top: 120px;
  font-size: unset;
`
export const PROFILE = styled.div`
  margin-top: 120px;
  font-size: unset;
  .container{
    display: flex;
  }
  @media screen and (max-width: 600px) {
    display: grid;
    .container{
      display: block;
    }
  }
`

export const ADVANCED = styled.div`
  margin-top: 120px;
  font-size: unset;
  margin-bottom: 20px;
  .container{
    display: flex;
  }
  @media screen and (max-width: 600px) {
    display: grid;
    .container{
      display: block;
    }
  }
`
