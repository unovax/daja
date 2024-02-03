<h1 align="center">Daja - Textile Industry Management Application</h1>

<p align="center">
  Daja is a user-friendly application designed for the textile industry. It simplifies task and client management, providing a streamlined solution for your business needs.
</p>

<h2 align="center">Installation</h2>

<ol>
  <li>Clone the repository to your local machine:</li>
    <div class="code">
      <strong>git clone https://github.com/your-username/daja.git</strong>
    </div>
  <li>Navigate to the project directory:</li>
    <div class="code">
      <strong>cd daja</strong>
    </div>
  <li>Install PHP dependencies using Composer:</li>
  <div class="code">
    <strong> composer install</strong>
  </div>
  <li>Install JavaScript dependencies using npm:</li>
    <div class="code">
      <strong>npm install</strong>
    </div>
  <li>Copy the example environment file and update it with your configuration:</li>
    <div class="code">
      <strong>cp .env.example .env</strong>
    </div>
  Update the necessary information in the .env file, such as the database connection details.

  <li>Generate the application key:</li>
    <div class="code">
      <strong>php artisan key:generate</strong>
    </div>
  <li>Create a symbolic link to the storage directory:</li>
  <div class="code">
    <strong> php artisan storage:link</strong>
  </div>
  <li>Run the database migrations:</li>
    <div class="code">
      <strong>php artisan migrate</strong>
    </div>
</ol>
<h2 align="center">Running the Development Server</h2>
<p>Once the installation is complete, start the development server with the following commands:</p>
<ol>
  <li>Compile and watch assets for changes:</li>
    <div class="code">
      <strong>npm run dev</strong>
    </div>
  <li>Start the Laravel development server:</li>
  <div class="code">
    <strong> php artisan serve</strong>
  </div>
</ol>
<p>Visit <a href="http://localhost:8000">http://localhost:8000</a> in your web browser to access the Daja application.</p>
<h2 align="center">Contributing</h2>
<p>Feel free to contribute to the development of Daja by opening issues or submitting pull requests. We welcome your feedback and collaboration.</p>
<h2 align="center">License</h2>
<p>This project is licensed under the <a href="LICENSE">MIT License</a>.</p>

<style>
  .code {
    background-color: #f4f4f4;
    padding: 10px;
    margin-bottom: 10px;
  }
  .code strong {
    color: #000;
  }
  .code a {
    color: #000;
  }
</style>
