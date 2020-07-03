<div class="col s12">
  <div class="container">
      <div class="section">
          <div class="card mb-0">
              <div class="card-content p-0">
                <ul class="collapsible m-0">
                  <li class="active">
                    <div class="collapsible-header p-0">
                      <div class="row">
                        <div class="col s12 m8">
                          <div class="collapsible-main-header">
                            <i class="material-icons expand">expand_less</i>
                            <span>Claim Notes Unit</span>
                          </div>
                          <a href="{{ url('claim-notes/create-unit') }}" class="btn btn-large waves-effect waves-light btn-add right no-propagation" type="submit" name="action">
                            New Claim Note Unit
                          </a>
                        </div>
                        <div class="col s12 m4">
                          <div class="app-wrapper">
                            <div class="datatable-search mb-0">
                              <i class="material-icons mr-2 search-icon">search</i>
                              <input type="text" placeholder="Search" class="app-filter no-propagation" id="global_filter">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="collapsible-body p-0">

                      <div class="section-data-tables"> 
                        <table id="data-table-claim-notes-unit" class="display" width="100%">
                            <thead>
                                <tr>
                                  <th data-priority="1" width="30px">NO.</th>
                                  <th>BERITA ACARA</th>
                                  <th>CLAIM NOTE</th>
                                  <th>REPORTING DATE</th>
                                  <th>EXPEDITION NAME</th>
                                  <th>DESTINATION</th>
                                  <th width="50px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1.</td>
                                <td>01/BA-HQ/02/2015</td>
                                <td>01/Claim CB-Nittsu/Okt/2017</td>
                                <td>13-Oct 2019</td>
                                <td>NITTSU LEMO INDONESIA LOGISTIK, PT.</td>
                                <td>Mishandling Swadaya</td>
                                <td>
                                  {!! get_button_view(url('claim-notes/create-unit')) !!}
                                  {!! get_button_print() !!}
                                </td>
                              </tr>
                            </tbody>
                        </table>
                      </div>
                      <!-- datatable ends -->
             
                    </div>
                  </li>
                </ul>
              </div>
          </div>
      </div>
  </div>
</div>

@push('script_js')
<script type="text/javascript">
  var dtdatatable_unit = $('#data-table-claim-notes-unit').DataTable({
      serverSide: false,
      responsive: true,
      order: [1, 'asc'],
    });
</script>
@endpush