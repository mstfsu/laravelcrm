<div class="row">
    <form class="save_reseller_settings modal-content pt-0">
        <div class="row">
            <div class="col-md-12">

                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">Backup Settings</h5>
                </div>
                <div class="modal-body flex-grow-1">

                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">Daily Creation Time:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="fp-time" name="auto_daily_backup_time" class="form-control flatpickr-time text-left" placeholder="HH:MM" value="{{\App\Models\Settings::get('auto_daily_backup_time')}}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name">Keep Backups For (Days):</label>
                            </div>
                            <div class="col-sm-9">
                               <input type="number " class="form-control" id='keep_daily_backups_for_days' name="keep_daily_backups_for_days" value="{{\App\Models\Settings::get('keep_daily_backups_for_days')}}">
                             </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group row">
                            <div class="col-sm-3 col-form-label">
                                <label for="first-name"> Backup Frequency:</label>
                            </div>
                            <div class="col-sm-9">
                              <select name="get_backup_frequency" id="get_backup_frequency" class="form-control">
                                  <option value="daily" @if(\App\Models\Settings::get('get_backup_frequency')=='daily') selected @endif>Daily</option>
                                  <option value="weekly" @if(\App\Models\Settings::get('get_backup_frequency')=='weekly') selected @endif>Weekly</option>
                                  <option value="monthly" @if(\App\Models\Settings::get('get_backup_frequency')=='monthly') selected @endif>Monthly</option>
                                  <option value="yearly" @if(\App\Models\Settings::get('get_backup_frequency')=='yearly') selected @endif>Yearly</option>
                              </select>
                            </div>
                        </div>
                    </div>














                </div>




                <button type="submit" id="save_reseller_btn" class="btn btn-primary mr-1 data-submit">Submit</button>

            </div>
        </div>


    </form>
</div>
