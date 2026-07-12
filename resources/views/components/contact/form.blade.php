<form action="{{ route('contact_store') }}" method="POST">
    @csrf
    <div class="mb-4">
        <input name="name" type="text" class="form-control mb-1" placeholder="نام و نام خانوادگی" />
        <div class="form-text text-danger">@error('name') {{$message}} @enderror</div>
    </div>
    <div class="mb-4">
        <input name="email" type="text" class="form-control mb-1" placeholder="ایمیل" />
        <div class="form-text text-danger">@error('email') {{$message}} @enderror</div>
    </div>
    <div class="mb-4">
        <input name="subject" type="text" class="form-control mb-1" placeholder="موضوع پیام" />
        <div class="form-text text-danger">@error('subject') {{$message}} @enderror</div>
    </div>
    <div class="mb-4">
        <textarea name="body" rows="10" style="height: 100px" class="form-control mb-1" placeholder="متن پیام"></textarea>
        <div class="form-text text-danger">@error('body') {{$message}} @enderror</div>
    </div>
    <div class="btn_box">
        <button type="submit">
            ارسال پیام
        </button>
    </div>
</form>