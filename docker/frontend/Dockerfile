FROM node:18.14-alpine

WORKDIR /app

COPY ./frontend/package.json ./
COPY ./frontend/package-lock.json ./

RUN npm install

EXPOSE 8080

CMD [ "npm", "run", "serve" ]