<div class="form-row">
    <div class="form-group col-md-12 {{ $errors->has('Number') ? 'is-invalid' : '' }}">
        <label>رقم التعميم</label>
        <input type="text" name="Number" id="Number" class="inputMaterial" value="">
        <div class="invalid-feedback">{{ $errors->first('Number') }}</div>
    </div>
    <div class="form-group col-md-12">
        <label>تاريخ التعميم</label>
        <input type="text" name="Time" id="Time" class="inputMaterial" value="">
    </div>

    <div class="form-group col-md-12">
        <label>النوع</label>
        <select name="MemoTypeId" class="inputMaterial" id="MemoTypeId" required>
            <option value="">--برجاء الاختيار--</option>
            @foreach ($memoTypes as $item)
            <option value="{{$item->Id}}">{{ $item->Description }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label>حالة التعميم</label>
        <select name="SuperVisingOrgId" class="inputMaterial" id="SuperVisingOrgId" required>
            <option value="">--برجاء الاختيار--</option>
            @foreach ($orgs as $org)
            <option value="{{ $org->Id }}">{{ $org->Description }}</option>
            @endforeach
        </select>
    </div>
    <!--
        <div class="form-group col-md-12">
            <label>صادر من</label>
            <select name="Origin" class="inputMaterial" id="Origin" required>
                <option value="">--برجاء الاختيار--</option>
                <option value="0">{{ __('memos/create.internal') }}</option>
                <option value="1">{{ __('memos/create.external') }}</option>
            </select>
        </div>
        -->
    <div class="form-group col-md-12">
        <p><label>المراكز التى سيتم الارسال لها</label></p>
        @foreach ($offices as $office)
        <div class="check">
            <label>{{ $office->Name }}</label>
            <input type="checkbox" name="offices[]" value="{{ $office->Id }}">
        </div>
        @endforeach
    </div>
    <div class="form-group col-md-12">
        <label>نبذه مختصره</label>
        <textarea type="text" name="Brief" id="Brief" class="form-control" value=""></textarea>
    </div>
    <div class="form-group col-md-12">
        <label>المرفقات</label>
        <input type="file" name="" id="" class="form-control" value="">
    </div>
    <div class="form-group col-md-12">
        <input type="submit" class="btn blue-Bold btn-primary float-left m-t-20 m-b-20" value="اضافة">
    </div>
</div>