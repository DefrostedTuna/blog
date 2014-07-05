<?php 

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Post extends Eloquent implements SluggableInterface {

    use SluggableTrait;

    protected $fillable = array("author_id", "title", "slug", "body", "cover_photo", "visible", "featured");

    protected $table = 'posts';

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );

    public function author() {
    	return $this->belongsTo('User', 'author_id');
    }

    public function comments() {
    	return $this->hasMany('Comment', 'post_id');
    }

    public function approvedComments() {
        return $this->hasMany('Comment', 'post_id')->where('approved', '=', 1);
    }

    public function images() {
        return $this->hasMany('Image', 'post_id');
    }

    public static function search($query, $p = 10) {

        return  Post::where('visible', '=', 1)
                ->where('title', 'LIKE', '%' . $query . '%')
                ->orWhere('body', 'LIKE', '%' . $query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate($p);

    }

    public static function archiveByYear() {
        return  Post::select(DB::raw('YEAR(created_at) year, COUNT(*) post_count'))
                ->where('visible', '=', 1)
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->get();
    }

    public static function archiveByMonth($year = null) {
        if($year) { // if year is supplied, return for that given year
            return  Post::select(DB::raw('MONTH(created_at) month, MONTHNAME(created_at) month_name, COUNT(*) post_count'))
                    ->where('visible', '=', 1)
                    ->whereRaw('YEAR(created_at) =' . $year)
                    ->groupBy('month')
                    ->orderBy('month', 'desc')
                    ->get();
        } else { //return all months
            return  Post::select(DB::raw('MONTH(created_at) month, MONTHNAME(created_at) month_name, COUNT(*) post_count'))
                    ->where('visible', '=', 1)
                    ->groupBy('month')
                    ->orderBy('month', 'desc')
                    ->get();
        }
    }

    public static function findBySlug($slug) {
        return Post::where('slug', '=', $slug)->first();
    }

    public static function getVisible($p = null) {
        return Post::where('visible', '=', 1)->orderBy('created_at', 'desc')->paginate($p);
    }

    public static function getMonth($m) {
       if(is_integer($m)) {
            return Post::where('visible', '=', 1)->whereRaw('MONTH(created_at) =' . $m)->orderBy('created_at', 'desc')->get();
       } else {
            return Post::where('visible', '=', 1)->whereRaw('MONTHNAME(created_at) =' . $m)->orderBy('created_at', 'desc')->get();
       }
    }

    public static function getFeatured() {
        return Post::where('featured', '=', 1)->where('visible', '=', 1)->orderBy('created_at', 'desc')->get();
    }

    public static function getRecent() {
        return Post::where('visible', '=', 1)->orderBy('created_at', 'desc')->take(5)->get();
    }

    public function published() {
        return $this->created_at->format('D F jS, Y'); //format('D M d, Y')
    }

    public function publishedShort() {
        return $this->created_at->format('F jS, Y'); //format('M d, Y')
    }

    public function deleteImages() {
        
        $images         = $this->images;

        $local_images   = array();
        $local_thumbs   = array();

        foreach($images as $image) {
            $local_images[] = public_path() . $image->path;
            $local_thumbs[] = public_path() . $image->thumb;
        }
        
        File::delete($local_images);
        File::delete($local_thumbs);

        return $this->images()->delete();

    }
}