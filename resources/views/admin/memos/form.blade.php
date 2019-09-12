<div class="form-row">
    <div class="form-group col-md-12 {{ $errors->has('Number') ? 'is-invalid' : '' }}">
        <label>رقم التعميم</label>
        <input type="text" name="Number" id="Number" class="inputMaterial" value="" required>
        <div class="invalid-feedback">{{ $errors->first('Number') }}</div>
    </div>
    <div class="form-group col-md-12 {{ $errors->has('Time') ? 'is-invalid' : '' }}">
        <label>تاريخ التعميم</label>
        <!--<input type="text" name="Time" id="Time" class="inputMaterial" value="" required>-->

        <input type="text" name="Time" id="Time" class="inputMaterial" value="YYYY-MM-DD" required />

        <div class="invalid-feedback">{{ $errors->first('Time') }}</div>
    </div>

    <div class="form-group col-md-12 {{ $errors->has('MemoTypeId') ? 'is-invalid' : '' }}">
        <label>النوع</label>
        <select name="MemoTypeId" class="inputMaterial" id="MemoTypeId" required>
            <option value="">--برجاء الاختيار--</option>
            @foreach ($memoTypes as $item)
            <option value="{{$item->Id}}">{{ $item->Description }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">{{ $errors->first('MemoTypeId') }}</div>
    </div>
    <div class="form-group col-md-12 {{ $errors->has('offices') ? 'is-invalid' : '' }}">
        <p><label>مرسل إلى</label></p>
        <dl class="dropdown">
            <dt>
                <a>
                    <p class="multiSel"><span class="hida">-- برجاء الاختيار --</span></p>
                </a>

            </dt>
            <dd>
                <div class="mutliSelect">
                    <ul>
                        <li><input type="checkbox" name="offices[]" value="0" id="select-all" /><span>جميع
                                المراكز</span></li>
                        @foreach ($offices as $office)
                        <li><input type="checkbox" name="offices[]"
                                value="{{ $office->Id }}" /><span>{{ str_limit($office->Name, 40, '...') }}</span></li>
                        @endforeach
                    </ul>
                </div>
            </dd>
        </dl>
        <div class="invalid-feedback">{{ $errors->first('offices') }}</div>
    </div>

    <div class="form-group col-md-12 {{ $errors->has('Brief') ? 'is-invalid' : '' }}">
        <label>نص التعميم</label>
        <textarea type="text" rows="20" name="Brief" id="Brief" class="form-control" value="" required></textarea>
        <div class="invalid-feedback">{{ $errors->first('Brief') }}</div>
    </div>

    <div class="form-group col-md-12 {{ $errors->has('filenames') ? 'is-invalid' : '' }}">
        <div class="input-group hdtuto control-group lst increment {{ $errors->has('file') ? 'is-invalid' : '' }}">
            <input type="file" name="filenames[]" class="myfrm form-control">
            <div class="input-group-btn">
                <button class="btn btn-success" type="button"><i
                        class="fldemo glyphicon glyphicon-plus"></i>Add</button>
            </div>
        </div>

        <div class="clone hide">
            <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                <input type="file" name="filenames[]" class="myfrm form-control">
                <div class="input-group-btn">
                    <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i>
                        Remove</button>
                </div>
            </div>
        </div>
        <div class="invalid-feedback">{{ $errors->first('filenames') }}</div>
    </div>
</div>



<div class="form-group col-md-12">
    <input type="submit" class="btn blue-Bold btn-primary float-left m-t-20 m-b-20" value="اضافة">
</div>
</div>