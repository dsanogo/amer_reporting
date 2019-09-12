<div class="form-row">
    <div class="form-group col-md-12 {{ $errors->has('Number') ? 'is-invalid' : '' }}">
        <label>رقم التعميم</label>
        <input type="text" name="Number" id="Number" class="inputMaterial" value="{{ $memo->Id ? $memo->Number : old('Number') }}" required>
        <div class="invalid-feedback">{{ $errors->first('Number') }}</div>
    </div>
    <div class="form-group col-md-12 {{ $errors->has('Time') ? 'is-invalid' : '' }}">
        <label>تاريخ التعميم</label>
        <input type="text" name="Time" id="Time" class="inputMaterial" value="{{ $memo->Id ? $memo->Time : old('Time') }}" required />
        <div class="invalid-feedback">{{ $errors->first('Time') }}</div>
    </div>

    <div class="form-group col-md-12 {{ $errors->has('MemoTypeId') ? 'is-invalid' : '' }}">
        <label>النوع</label>
        <select name="MemoTypeId" class="inputMaterial" id="MemoTypeId" required>
            <option value="">--برجاء الاختيار--</option>
            @foreach ($memoTypes as $item)
            <option {{$memo->MemoTypeId == $item->Id ? 'selected' : '' }} value="{{$item->Id}}">{{ $item->Description }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">{{ $errors->first('MemoTypeId') }}</div>
    </div>
    <div class="form-group col-md-12 {{ $errors->has('offices') ? 'is-invalid' : '' }}">
        <p><label>مرسل إلى</label></p>
        <dl class="dropdown">
            <dt>
                <a>
                    @if ($memo->Id)
                    @if(count($memoOfficesIds) > 0)
                    <p class="multiSel">
                        @foreach ($offices as $office)
                        {{ in_array($office->Id, $memoOfficesIds) ? $office->Name . '…' : '' }}
                        @endforeach
                        <span class="hida" style="display: none;">-- برجاء الاختيار --</span>
                    </p>
                    @else
                    <p class="multiSel"><span class="hida">-- برجاء الاختيار --</span></p>
                    @endif
                    @else
                    <p class="multiSel"><span class="hida">-- برجاء الاختيار --</span></p>
                    @endif
                </a>

            </dt>
            <dd>
                <div class="mutliSelect">
                    <ul>
                        <li><input type="checkbox" name="offices[]" value="0" id="select-all" /><span>جميع المراكز</span></li>
                        @if($memo->Id)
                        @foreach ($offices as $office)
                        <li><input type="checkbox" name="offices[]" value="{{ $office->Id }}" {{ in_array($office->Id, $memoOfficesIds) ? 'checked' : '' }}/><span>{{ str_limit($office->Name, 40, '...') }}</span></li>
                        @endforeach
                        @else
                        @foreach ($offices as $office)
                        <li><input type="checkbox" name="offices[]" value="{{ $office->Id }}"/><span>{{ str_limit($office->Name, 40, '...') }}</span></li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </dd>
        </dl>
        <div class="invalid-feedback">{{ $errors->first('offices') }}</div>
    </div>

    <div class="form-group col-md-12 {{ $errors->has('Brief') ? 'is-invalid' : '' }}">
        <label>نص التعميم</label>
        <textarea type="text" rows="20" name="Brief" id="Brief" class="form-control" required>{{ $memo->Id ? $memo->Brief : old('Brief') }}</textarea>
        <div class="invalid-feedback">{{ $errors->first('Brief') }}</div>
    </div>

    <div class="form-group col-md-12 {{ $errors->has('filenames') ? 'is-invalid' : '' }}">
        <div class="input-group hdtuto control-group lst increment {{ $errors->has('file') ? 'is-invalid' : '' }}">
            <input type="file" name="filenames[]" class="myfrm form-control" >
            <div class="input-group-btn">
                <button class="btn btn-success add-btn" type="button"><i class="fldemo glyphicon glyphicon-plus"></i>Add</button>
            </div>
        </div>

        <div class="clone hide">
            <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                <input type="file" name="filenames[]" class="myfrm form-control" >
                <div class="input-group-btn">
                    <button class="btn btn-danger" type="button"><i class="fldemo glyphicon glyphicon-remove"></i>Remove</button>
                </div>
            </div>
        </div>
        <div class="invalid-feedback">{{ $errors->first('filenames') }}</div>
    </div>
    
    @if ($memo->Id)
    @if (count($memoAttachments) > 0)
    
        @foreach ($memoAttachments as $memoAttachments)
        <div class="gallery">
            <a target="_blank" href="{{ URL::to("public/uploads/memos") . '/' . $memoAttachments->Path }}">
                <img src="{{ URL::to("public/uploads/memos") . '/' . $memoAttachments->Path }}" alt="Cinque Terre" width="600" height="400">
            </a>
            <div class="desc">{{ $memoAttachments->Name }}</div>
        </div>
        @endforeach
    
    @endif
    @endif

</div>

@if($memo->Id)
<input name="Id" id="id" type="hidden" value="{{$memo->Id}}">
@endif

<div class="form-group col-md-12">
    <input type="submit" class="btn blue-Bold btn-primary float-left m-t-20 m-b-20" value="{{$memo->Id ? 'حفظ التعديلات' : 'اضافة تعميم'}}">
</div>
</div>