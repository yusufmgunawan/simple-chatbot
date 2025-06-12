<h1>🤖 Simple Chatbot with PrismPHP</h1>

<p>
  Ini adalah proyek chatbot sederhana berbasis <strong>Laravel</strong> menggunakan <a href="https://github.com/prism-php/prism" target="_blank">PrismPHP</a> sebagai jembatan ke berbagai LLM (Large Language Model) provider.
</p>

<hr>

<h2>🧠 Apa Itu PrismPHP?</h2>
<p>
  <a href="https://github.com/prism-php/prism" target="_blank">PrismPHP</a> adalah package PHP yang menyediakan antarmuka sederhana dan seragam untuk menggunakan berbagai model AI dari berbagai penyedia seperti OpenAI, Groq, Anthropic, Cohere, dan lainnya.
</p>

<hr>

<h2>🛠️ Teknologi dan Package yang Digunakan</h2>
<ul>
  <li><strong>Laravel</strong> - PHP framework untuk backend</li>
  <li><strong>PrismPHP</strong> - Package untuk komunikasi dengan LLM</li>
  <li><strong>Groq API</strong> - Provider LLM, dalam kasus ini menggunakan <code>llama3-70b-8192</code></li>
</ul>

<hr>

<h2>🚀 Cara Menjalankan Proyek Ini</h2>

<ol>
  <li>Clone repositori ini:
    <pre><code>git clone https://github.com/username/nama-repo-kamu.git</code></pre>
  </li>
  <li>Masuk ke folder proyek:
    <pre><code>cd nama-repo-kamu</code></pre>
  </li>
  <li>Install dependency dengan Composer:
    <pre><code>composer install</code></pre>
  </li>
  <li>Copy file environment:
    <pre><code>cp .env.example .env</code></pre>
  </li>
  <li>Generate app key:
    <pre><code>php artisan key:generate</code></pre>
  </li>
  <li>Tambahkan API key Groq kamu di file <code>.env</code>:
    <pre><code>GROQ_API_KEY=masukkan_api_key_kamu_disini</code></pre>
  </li>
  <li>Jalankan Laravel server:
    <pre><code>php artisan serve</code></pre>
  </li>
  <li>Buka browser dan kunjungi:
    <pre><code>http://localhost:8000</code></pre>
  </li>
</ol>

<hr>

<h2>💬 Struktur Controller Chat</h2>

<ul>
  <li><code>ChatController@index</code>: Menampilkan halaman dengan pesan sambutan dari LLM.</li>
  <li><code>ChatController@send</code>: Meneruskan pesan dari user ke LLM dan mengembalikan balasan.</li>
</ul>

<hr>

<h2>🔁 Cara Mengganti Provider Lain</h2>

<p>Untuk menggunakan provider lain seperti OpenAI, Anthropic, atau lainnya:</p>

<ol>
  <li>Ganti provider di bagian berikut:
    <pre><code>
->using(Provider::Groq, 'llama3-70b-8192')
    </code></pre>
    Menjadi misalnya:
    <pre><code>
->using(Provider::OpenAI, 'gpt-3.5-turbo')
    </code></pre>
  </li>

  <li>Ubah konfigurasi providernya juga:
    <pre><code>
->usingProviderConfig([
  'url' => 'https://api.openai.com/v1',
  'api_key' => env('OPENAI_API_KEY'),
])
    </code></pre>
  </li>

  <li>Jangan lupa menambahkan API key di file <code>.env</code>:
    <pre><code>OPENAI_API_KEY=masukkan_api_key_openai_kamu_disini</code></pre>
  </li>
</ol>

<hr>

<h2>📦 Referensi</h2>
<ul>
  <li><a href="https://github.com/prism-php/prism" target="_blank">PrismPHP GitHub</a></li>
  <li><a href="https://docs.prismphp.dev" target="_blank">PrismPHP Documentation</a></li>
  <li><a href="https://console.groq.com/" target="_blank">Groq Console</a></li>
</ul>

<hr>

<h2>🤝 Kontribusi</h2>
<p>
  Pull request sangat diterima! Jangan ragu untuk fork dan kembangkan fitur chatbot ini.
</p>

<hr>

<h2>📄 Lisensi</h2>
<p>Proyek ini menggunakan lisensi MIT.</p>
