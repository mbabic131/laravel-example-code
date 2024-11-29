<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <article>
            <h1 class="text-xl font-bold">Title: {{ $article->title }}</h1>
            <br/>
            <p>Content: {{ $article->content }}</p>
        </article>
    </div>
</x-app-layout>