<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use Kenarkose\Transit\Contract\HasMetadata as HasMetadataContract;
use Kenarkose\Transit\File\HasMetadata;

class ItemHasMetadata extends Eloquent implements HasMetadataContract {

    use HasMetadata;

}