<?php echo '<?php'; ?>

namespace {{ $namespace }};


use Illuminate\Database\Eloquent\Model as Eloquent;
use Kenarkose\Transit\File as TransitFile;

class {{ $name }} extends TransitFile {

    /**
     * The fillable fields for the model.
     *
     * @var array
     */
    protected $fillable = ['extension', 'mimetype', 'size', 'filename'];

}