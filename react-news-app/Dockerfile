# Stage 1: Build the React app
FROM node:14 as build-stage

WORKDIR /app

COPY package.json /app/

RUN npm install

COPY . /app

RUN npm run build

# Stage 2: Serve the built React app using Nginx
FROM nginx:1.21

COPY --from=build-stage /app/build /usr/share/nginx/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
