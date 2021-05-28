<h2>Prerequisites:</h2>
<ul>
    <li>git</li>
    <li>php</li>
    <li>composer</li>
    <li>npm</li>
</ul>


<h2>Install:</h2>
<ul>
    <li>git clone</li>
    <li>copy .env.example .env</li>
    <li>composer install</li>
    <li>php artisan key:generate</li>
    <li>npm install</li>
    <li>touch database/database.sqlite</li>
    <li>php artisan migrate</li>
</ul>


<h2>Run in dev:</h2>
<ul>
    <li>php artisan serve</li>
    <li>npm run watch</li>
</ul>
<p>serving on localhost:3000</p>


<h2>Testing:</h2>
<ul>
    <li>touch database/test.sqlite</li>
    <li>php artisan --env=testing migrate:fresh --seed</li>
    <li>php artisan test</li>
</ul>