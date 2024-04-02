# Blog
A fully develop Blog CRUD package that allows you to manage blogs, using Blog content managing meta data with Tags & Collections.

**How does this package work?**
This package offers a few aspects and provides a great base for creating a blog page for your project. The main features are:
1. A Blog model with the ability to add tags and make it part of a collection
2. Ability to add more users with author roles (which have default policy rules - which can be overwritten)
3. Built in Factories for easy seeding, development & testing
4. CRUD operations such as Actions, Requests & Controllers to be used - Controllers are coming soon...


**For Future reference**
The main 3 models of this package are:
1. Blog: Containing columns such as `title`, `author_id`, meta related columns and `content` ... and more
2. Tag: A `name` but can be added to a blog (A Blog HasMany Tags) - used to help users understand the base topics of the blog
3. Collection: A `name` and `description` - best used for concepts like a tutorial series (A blog BelongsToOne)

**Example Use Case**
1. A personal blog page which you want an easy implementation for to manage blogs
2. A new blog page where you can add multiple users with restrictions through the author rule + additional roles & policies

**What this package does not offer**
1. At this point in time this package does not offer a set of front end components. This is strictly a laravel crud package.
2. Manage separate users

## Steps for Development
### Installation (via composer)
`composer require sethsharp/blog-crud`

### Adding Service Provider
Add to your `config/app.php`

```php
'providers' => [
    \SethSharp\BlogCrud\BlogServiceProvider::class
]
```

### Publishing Migrations
Then to publish the migrations:
`php artisan vendor:publish --tag="blog-crud-migrations"`

### Other Requirements
**File System**
This package does rely on AWS S3 logic when it comes to file uploads, via the Blog Cover or the images you can upload within your blog.
So ensure that your AWS credentials are properly configured, specifically this array within your `config/filesystems`:
```php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    'throw' => false,
],
```

**Slack Notifications**

## Usage
It is encouraged that you explore this package, it is very straight forward and simple so it is easy to integrate what it has to offer for your use case.
As the logic you implement to use Actions & Requests may be different to others, as well as other practises.
However, lets go over some basic use cases.

### Update a Blog
```php
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use SethSharp\BlogCrud\Models\Blog\Blog;
use SethSharp\BlogCrud\Actions\Blogs\UpdateBlogAction;
use SethSharp\BlogCrud\Requests\Blogs\UpdateBlogRequest;

class UpdateBlogController extends Controller
{
    public function __invoke(Blog $blog, UpdateBlogRequest $updateBlogRequest, UpdateBlogAction $updateBlogAction): RedirectResponse
    {
        $blog = $updateBlogAction($blog, $updateBlogRequest);

        $drafted = (bool)$updateBlogRequest->input('is_draft');

        return redirect()
            ->route('dashboard.blogs.index')
            ->with('success', $blog->title . ' successfully ' . ($drafted ? 'drafted' : 'published'));
    }
}
```
This is an example `UpdateBlogController`, using all the files from the package; `Blog`, `UpdateBlogRequest` & `UpdateBlogAction`.
Reading each of these files will ive you an understanding of what they expect - so its up to you to ensure you pass the correct information.

### Tips
If you wanted to add another column such as `publish_at` to define when to publish the blog through a console command, you just need to define this
attribute by extending the rules in the `UpdateBlogRequest`, then passing that data to `UpdateBlogAction` it will automatically assign that variable. Any
further logic will need to be manually done by yourself.