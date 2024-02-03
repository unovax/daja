<h1 align="center">Daja - Textile Industry Management Application</h1>

<p align="center">
  Daja is a user-friendly application designed for the textile industry. It simplifies task and client management, providing a streamlined solution for your business needs.
</p>

<h2 align="center">Installation</h2>

<ol>
  <li>Clone the repository to your local machine:</li>
  git clone https://github.com/your-username/daja.git
  <li>Navigate to the project directory:</li>
  cd daja
  <li>Install PHP dependencies using Composer:</li>
  composer install
  <li>Install JavaScript dependencies using npm:</li>
  npm install
  <li>Copy the example environment file and update it with your configuration:</li>
  cp .env.example .env
  Update the necessary information in the .env file, such as the database connection details.

  <li>Generate the application key:</li>
  php artisan key:generate
  <li>Create a symbolic link to the storage directory:</li>
  php artisan storage:link
  <li>Run the database migrations:</li>
  php artisan migrate
</ol>
<h2 align="center">Running the Development Server</h2>
<p>Once the installation is complete, start the development server with the following commands:</p>
<ol>
  <li>Compile and watch assets for changes:</li>
  npm run dev
  <li>Start the Laravel development server:</li>
  php artisan serve
</ol>
<p>Visit <a href="http://localhost:8000">http://localhost:8000</a> in your web browser to access the Daja application.</p>
<h2 align="center">Contributing</h2>
<p>Feel free to contribute to the development of Daja by opening issues or submitting pull requests. We welcome your feedback and collaboration.</p>
<h2 align="center">License</h2>
<p>This project is licensed under the <a href="LICENSE">MIT License</a>.</p>
