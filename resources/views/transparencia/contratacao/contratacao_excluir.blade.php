@extends('navbar.default-navbar')
@section('content')

    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{ $unidade->name }}</strong></div>
    <div class="container-fluid">
        <div class="row" style="margin-top: 25px;">
            <div class="col-md-12 text-center">
                <h3 style="font-size: 18px;">EXCLUIR CONTRATAÇÕES:</h3>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row" style="margin-top: 25px;">
            <div class="col-md-12 col-sm-12 text-center">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <a class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <strong>Contratos</strong>
                                </a>
                            </h2>
                        </div>
                        <form action="{{ \Request::route('destroy'), $unidade->id }}" method="post"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <table border="0" class="table table-sm">
                                <tr>
                                    <td> ID Prestador: </td>
                                    <td> <input class="form-control" style="width: 90px;" readonly="true" type="text"
                                            id="prestador_id" name="prestador_id" value="<?php echo $prestador[0]->id; ?>"> </td>
                                </tr>
                                <tr>
                                    <td> Prestador: </td>
                                    <td> <input class="form-control" style="width: 500px;" readonly="true" type="text"
                                            id="prestador" name="prestador" value="<?php echo $prestador[0]->prestador; ?>">
                                </tr>
                                <tr>
                                    <td> <br /> </td>
                                </tr>
                                <tr>
                                    <td> ID Contrato: </td>
                                    <td> <input class="form-control" style="width: 90px;" readonly="true" type="text"
                                            id="id" name="id" value="<?php echo $contratos[0]->id; ?>" /> </td>
                                    </td>
                                <tr>

                                    <td> Título: </td>
                                    <td> <input class="form-control" style="width: 500px;" readonly="true" type="text"
                                            id="objeto" name="objeto" value="<?php echo $contratos[0]->objeto; ?>" /> </td>
                                </tr>
                                <tr>
                                    <td> Aditivo: </td>
                                    <td>
                                        <select style="width: 100px;" readonly="true" name="aditivos" id="aditivos"
                                            style="width: 300px;" class="form-control">
                                            <option value="<?php echo $contratos[0]->objeto; ?>">
                                                <?php if ($contratos[0]->aditivos === 1) { ?> SIM <?php } else { ?> NÃO <?php } ?>
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Valor: </td>
                                    <td> <input style="width: 100px;" readonly="true" class="form-control" type="number"
                                            id="valor" name="valor" value="<?php echo $contratos[0]->valor; ?>" /> </td>
                                </tr>
                                <tr>
                                    <td> Início: </td>
                                    <td> <input style="width: 200px;" readonly="true" class="form-control" type="date"
                                            id="inicio" name="inicio" value="<?php echo $contratos[0]->inicio; ?>" /> </td>
                                </tr>
                                <tr>
                                    <td> Fim: </td>
                                    <td> <input style="width: 200px;" readonly="true" class="form-control" type="date"
                                            id="fim" name="fim" value="<?php echo $contratos[0]->fim; ?>" /> </td>
                                </tr>
                                <tr>
                                    <td> Renovação Automática: </td>
                                    <td>
                                        <select style="width: 100px;" readonly="true" name="renovacao_automatica"
                                            id="renovacao_automatica" class="form-control">
                                            <option value="<?php $contratos[0]->renovacao_automatica; ?>"> <?php if ($contratos[0]->renovacao_automatica === 1) { ?> SIM
                                                <?php } else { ?> NÃO <?php } ?> </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Arquivo: </td>
                                    <td> <input style="width: 500px;" readonly="true" class="form-control" type="text"
                                            id="file_path" name="file_path" title="{{ $contratos[0]->file_path }}"
                                            value="<?php echo $contratos[0]->file_path; ?>" /> </td>
                                </tr>
                                <tr>
                                    <td> <br /> </td>
                                </tr>
                                @foreach ($aditivos as $aditivo)
                                    @if ($aditivo->vinculado == '1º Contrato' && ($aditivo->opcao == 1 || $aditivo->opcao == 2))
                                        <tr>
                                            @if ($aditivo->opcao == 1)
                                                <td> ID Aditivo:</td>
                                            @else
                                                <td> ID Distrato:</td>
                                            @endif
                                            <td> <input style="width: 90px;" readonly="true" class="form-control"
                                                    type="text" id="file_path" name="file_path"
                                                    value="<?php echo $aditivo->id; ?>" /> </td>
                                        </tr>
                                        <tr>
                                            <td> Arquivo: </td>
                                            <td> <input style="width: 500px;" readonly="true" class="form-control"
                                                    type="text" id="file_path" name="file_path"
                                                    title="{{ $aditivo->file_path }}" value="<?php echo $aditivo->file_path; ?>" />
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td class="col-3">
                                        <label>
                                            @if ($contratos[0]->inativa == 0)
                                                <strong style="color:red"> Inativar</strong>
                                            @else
                                                <strong style="color:green"> Ativar </strong>
                                            @endif
                                            <strong> aditivos</strong> e<strong>
                                                distratos</strong> vinculados a este contrato ?
                                        </label>
                                    </td>
                                    <td class="col-2">
                                        <label>Sim</label>
                                        <input type="radio" name="statusAditivosDistratos" id="statusAditivosDistratos"
                                            value="1">
                                        <label>Não</label>
                                        <input type="radio" name="statusAditivosDistratos" id="statusAditivosDistratos" value="0"
                                            checked>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <input hidden style="width: 100px;" type="text" id="unidade_id"
                                            name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
                                    <td> <input hidden type="text" class="form-control" id="tela" name="tela"
                                            value="contratacao" /> </td>
                                    <td> <input hidden type="text" class="form-control" id="acao" name="acao"
                                            value="excluirContratacao" /> </td>
                                    <td> <input hidden type="text" class="form-control" id="user_id" name="user_id"
                                            value="{{ Auth::user()->id }}" /> </td>
                                </tr>
                            </table>
                            <div class="border border-secondary rounded p-2">
                                <div class="d-flex justify-content-center">
                                    <h6> Deseja realmente
                                        @if ($contratos[0]->inativa == 0)
                                            <strong style="color:red"> Inativar </strong>
                                        @else
                                            <strong style="color:green"> Ativar </strong>
                                        @endif
                                        este Contrato??
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('transparenciaContratacao', $unidade->id) }}" id="Voltar"
                                        name="Voltar" type="button" class="btn btn-warning btn-sm"
                                        style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i>
                                    </a>
                                    @if ($contratos[0]->inativa == 0)
                                        <input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;"
                                            value="Inativar Contrato" id="Excluir" name="Excluir" />
                                    @else
                                        <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;"
                                            value="Ativar Contrato" id="Excluir" name="Excluir" />
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
