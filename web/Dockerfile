FROM node:22-alpine

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

# Garante a porta do Vite aberta
EXPOSE 5173

# Executa o servidor de desenvolvimento (não o build)
CMD ["npm", "run", "dev"]