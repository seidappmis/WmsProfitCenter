@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>User Roles</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">User Roles</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <form class="form-table">
                        <table>
                          <tr>
                            <td>Roles Name</td>
                            <td>
                              <div class="input-field col s12">
                                <input id="rname" type="text" class="validate" value="admincheck">
                              </div>
                            </td>
                          </tr>
                        </table>
                        <!-- Check All -->
                        <div class="row">
                          <div class="input-field col s12 mb-2">
                            <label><input class="filled-in" type="checkbox" onClick="toggle(this)" /><span>Check All</span></label>
                          </div>
                        </div>
                        <!-- Table Group Dashboard-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">DASHBOARD</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>Graphic Dashboard</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Graphic Dashboard 2</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Trucking Monitor</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <!-- Table Group Groupname-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">GROUPNAME</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>ModulName</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <!-- Table Group Incoming-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">INCOMING</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>Finish Good Production</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Incoming Import/OEM</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Conform Manifest</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked />
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Billing Return</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <!-- Table Group Inventory-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">INVENTORY</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>Storage Inventory Monitoring</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Upload Inventory Storage</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Adjust Inventory Movement</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Transfer SLoc</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Cancel Movement</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <!-- Table Group Invoicing-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">INVOICING</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>List Of Unconfirm DO</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Receipt Invoice</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Receipt Invoice Accounting</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Summary Freight Cost Analysis</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Branch Invoicing</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <!-- Table Group Master Data-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">Master Data</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>Master Gate</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Master Destination</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Master Vehicle</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Master Epxedition</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Master Vehicle Expedition</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <!-- Table Group Others-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">OTHERS</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>Clean Concept</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <!-- Table Group Outgoing-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">OUTGOING</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>Upload Concept</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>IDCard Scan</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Assign Vehicles</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <!-- Table Group Picking-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">PICKING</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>Upload DO for Picking</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Picking List</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Picking to LMB</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <!-- Table Group Reports-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">REPORTS</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>Report Master Users</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Report Master</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Standby Driver List</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <!-- Table Group Return-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">RETURN</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>Task Notice</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>List Of SO</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <!-- Table Group Setting-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">SETTING</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>User Manager</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>User Roles</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Master Area</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo"/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        <!-- Table Group Stock Take-->
                        <div class="col s12 mt-2">
                        <table width="100%">
                          <tr bgcolor="#344b68">
                            <td class="center-align white-text">STOCK TAKE</td>
                            <td width="10%" class="center-align white-text">View</td>
                            <td width="10%" class="center-align white-text">Modify</td>
                            <td width="10%" class="center-align white-text">Delete</td>
                          </tr>
                          <tr>
                            <td>Stock Take Schedule</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Stock Take Create Tag</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Stock Take Input 1</td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                            <td>
                              <div class="input-field col s12 center-align">
                                <p>
                                  <label>
                                    <input type="checkbox" class="filled-in" name="foo" checked/>
                                    <span></span>
                                  </label>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </div>
                        {!! get_button_save('Update') !!}
                        {!! get_button_cancel(url('user-roles')) !!}
                      </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
  // Checkbox
  function toggle(source) {
     checkboxes = document.getElementsByName("foo");
     for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;
     }
  }
  // var table = $('#data-table-simple').DataTable({
  //   "responsive": true,
  // });
</script>
@endpush
