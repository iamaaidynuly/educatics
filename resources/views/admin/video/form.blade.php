<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" name="name" class="form-control" id="name" value="{{\App\Models\Video::whereId($video->video_id)->value('name')}}">
        </div>
        <div class="form-group">
            <label for="name">Link</label>
            <input type="text" name="link" class="form-control" id="link" value="{{\App\Models\Video::whereId($video->video_id)->value('link')}}">
        </div>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Принять</button>
    </div>
</div>
