@extends('navbar.default-navbar')
@section('content')

    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{ $unidade->name }}</strong></div>
    <div class="container-fluid">
        <div class="row" style="margin-top: 25px;">
            <div class="col-md-12 text-center">
                <h3 style="font-size: 18px;">CONTRATAÇÕES</h3>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-success">
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
                    <!-- CONTRATOS -->
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <a class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <strong>Contratos</strong>
                                </a>
                                @if (Auth::check())
                                    <a href="{{ route('transparenciaContratacao', [$unidade->id]) }}"
                                        class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i
                                            class="fas fa-undo-alt"></i> </a>
                                    <a class="btn btn-dark btn-sm" style="color: #FFFFFF;"
                                        href="{{ route('cadastroContratos', $unidade->id) }}"> Novo <i
                                            class="fas fa-check"></i></a>
                                @endif
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>
                                <a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#obras"
                                    role="button" aria-expanded="false" aria-controls="collapseExample">
                                    OBRAS <i class="fas fa-hard-hat"></i>
                                </a>
                            </p>
                            <div class="collapse border-0" id="obras">
                                <div class="card card-body border-0">
                                    <p>
                                        <a style="width:200px;" class="btn btn-success" data-toggle="collapse"
                                            href="#obrasPessoaFisica" role="button" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            PESSOA FÍSICA <i class="fas fa-user-alt"></i>
                                        </a>
                                        <a style="width:200px;" class="btn btn-success" data-toggle="collapse"
                                            href="#obrasPessoaJuridica" role="button" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            PESSOA JURÍDICA <i class="fas fa-user-tie"></i>
                                        </a>
                                    </p>
                                    <div class="collapse border-0" id="obrasPessoaFisica">
                                        <div class="card card-body border-0">
                                            <div class="container">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">CPF</th>
                                                            <th scope="col">Pessoa</th>
                                                            <th scope="col">Objeto</th>
                                                            <th scope="col">Prazo</th>
                                                            <th scope="col">Opções</th>
                                                            <th scope="col">Alterar</th>
                                                            <th scope="col">Gestor</th>
                                                            <th scope="col">Excluir</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($contratos as $contrato)
                                                            @if ($contrato->tipo_contrato == 'OBRAS' && $contrato->tipo_pessoa == 'PESSOA FÍSICA')
                                                                <tr>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->cnpj_cpf }}">
                                                                        {{ $contrato->cnpj_cpf }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->prestador }}">
                                                                        {{ $contrato->prestador }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->objeto }}">
                                                                        {{ $contrato->objeto }}</td>
                                                                    <td>
                                                                        @if ($contrato->fim == null)
                                                                            'Tempo Indeterminado'
                                                                        @elseif($contrato->renovacao_automatica == 0)
                                                                            {{ date('d-m-Y', strtotime($contrato->fim)) }}
                                                                        @elseif($contrato->renovacao_automatica == 1)
                                                                            'Renovação Automática'
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a class="badge badge-pill badge-primary dropdown-toggle"
                                                                            type="button" href="dropdownMenuButton"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            Visualizar
                                                                        </a> <?php $id = 0; ?>
                                                                        <div id="div" class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton"
                                                                            style="font-size: 12px;">
                                                                            <?php if ($contrato->cadastro == 0 && $contrato->inativa == 0) {  ?>
                                                                            <a id="div" class="dropdown-item"
                                                                                href="{{ $contrato->file_path }}"
                                                                                target="_blank">1º Contrato</a>
                                                                            <?php } elseif ($contrato->cadastro == 1 && $contrato->inativa == 0) { ?>
                                                                            <a id="div" class="dropdown-item"
                                                                                href="{{ asset('storage/') }}/{{ $contrato->file_path }}"
                                                                                target="_blank">1º Contrato</a>
                                                                            <?php } ?> <?php $idC = 1; ?>
                                                                            <?php $aditivoVincula = 1; ?>
                                                                            @foreach ($aditivos as $aditivo)
                                                                                @if ($aditivo->contrato_id == $contrato->ID)
                                                                                    @if ($aditivo->opcao == 1)
                                                                                        <?php $id += 1;
                                                                                        if (substr($aditivo->vinculado, 0, 1) != $aditivoVincula) {
                                                                                            $id = 1;
                                                                                        }
                                                                                        ?>
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $id }}º
                                                                                                    Aditivo
                                                                                                    ({{ $aditivo->vinculado }})
                                                                                                </a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $id }}º
                                                                                                    Aditivo
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @endif
                                                                                        <?php $aditivoVincula = substr($aditivo->vinculado, 0, 1); ?>
                                                                                    @elseif($aditivo->opcao == 2)
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">Distrato
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">Distrato
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @endif
                                                                                    @else
                                                                                        <?php $idC += 1; ?>
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $idC }}º
                                                                                                    Contrato</a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $idC }}º
                                                                                                    Contrato</a></strong>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    <td> <a class="btn btn-info btn-sm"
                                                                            style="color: #FFFFFF;"
                                                                            href="{{ route('alterarContratos', [$unidade->id, $contrato->id, $contrato->ID]) }}"><i
                                                                                class="fas fa-edit"></i></a> </td>
                                                                    <td> <a class="btn btn-secondary btn-sm"
                                                                            style="color: #FFFFFF;"
                                                                            href="{{ route('responsavelCadastro', [$unidade->id, $contrato->id]) }}">
                                                                            <i class="bi bi-person-circle"></i></a> </td>
                                                                    <td>

                                                                        @if ($contrato->inativa == 0)
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('excluirContratos', [$unidade->id,  $contrato->ID]) }}">
                                                                                <i class="fas fa-times-circle"></i></a>
                                                                        @else
                                                                            <a class="btn btn-success btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('excluirContratos', [$unidade->id,  $contrato->ID]) }}">
                                                                                <i class="bi bi-check-lg"></i></a>
                                                                        @endif


                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse border-0" id="obrasPessoaJuridica">
                                        <div class="card card-body border-0">
                                            <div class="container">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">CNPJ</th>
                                                            <th scope="col">Empresa</th>
                                                            <th scope="col">Objeto</th>
                                                            <th scope="col">Prazo</th>
                                                            <th scope="col">Opções</th>
                                                            <th scope="col">Alterar</th>
                                                            <th scope="col">Gestor</th>
                                                            <th scope="col">Excluir</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($contratos as $contrato)
                                                            @if ($contrato->tipo_contrato === 'OBRAS' && $contrato->tipo_pessoa === 'PESSOA JURÍDICA')
                                                                <tr>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->cnpj_cpf }}">
                                                                        {{ $contrato->cnpj_cpf }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->prestador }}">
                                                                        {{ $contrato->prestador }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->objeto }}">
                                                                        {{ $contrato->objeto }}</td>
                                                                    <td>
                                                                        @if ($contrato->fim == null)
                                                                            'Tempo Indeterminado'
                                                                        @elseif($contrato->renovacao_automatica == 0)
                                                                            {{ date('d-m-Y', strtotime($contrato->fim)) }}
                                                                        @elseif($contrato->renovacao_automatica == 1)
                                                                            'Renovação Automática'
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a class="badge badge-pill badge-primary dropdown-toggle"
                                                                            type="button" href="dropdownMenuButton"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            Visualizar
                                                                        </a> <?php $id = 0; ?>
                                                                        <div id="div" class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton"
                                                                            style="font-size: 12px;">
                                                                            <?php if ($contrato->cadastro == 0 && $contrato->inativa == 0) {  ?>
                                                                            <a id="div" class="dropdown-item"
                                                                                href="{{ $contrato->file_path }}"
                                                                                target="_blank">1º Contrato</a>
                                                                            <?php } elseif ($contrato->cadastro == 1 && $contrato->inativa == 0) { ?>
                                                                            <a id="div" class="dropdown-item"
                                                                                href="{{ asset('storage/') }}/{{ $contrato->file_path }}"
                                                                                target="_blank">1º Contrato</a>
                                                                            <?php } ?> <?php $idC = 1; ?>
                                                                            <?php $aditivoVincula = 1; ?>
                                                                            @foreach ($aditivos as $aditivo)
                                                                                @if ($aditivo->contrato_id == $contrato->ID)
                                                                                    @if ($aditivo->opcao == 1)
                                                                                        <?php $id += 1;
                                                                                        if (substr($aditivo->vinculado, 0, 1) != $aditivoVincula) {
                                                                                            $id = 1;
                                                                                        }
                                                                                        ?>
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $id }}º
                                                                                                    Aditivo
                                                                                                    ({{ $aditivo->vinculado }})
                                                                                                </a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $id }}º
                                                                                                    Aditivo
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @endif
                                                                                        <?php $aditivoVincula = substr($aditivo->vinculado, 0, 1); ?>
                                                                                    @elseif($aditivo->opcao == 2)
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">Distrato
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">Distrato
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @endif
                                                                                    @else
                                                                                        <?php $idC += 1; ?>
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $idC }}º
                                                                                                    Contrato</a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $idC }}º
                                                                                                    Contrato</a></strong>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    <td> <a class="btn btn-info btn-sm"
                                                                            style="color: #FFFFFF;"
                                                                            href="{{ route('alterarContratos', [$unidade->id, $contrato->id, $contrato->ID]) }}"><i
                                                                                class="fas fa-edit"></i></a> </td>
                                                                    <td> <a class="btn btn-secondary btn-sm"
                                                                            style="color: #FFFFFF;"
                                                                            href="{{ route('responsavelCadastro', [$unidade->id, $contrato->id]) }}">
                                                                            <i class="bi bi-person-circle"></i></a> </td>
                                                                    <td>
                                                                        @if ($contrato->inativa == 0)
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('excluirContratos', [$unidade->id, $contrato->id, $contrato->ID]) }}">
                                                                                <i class="fas fa-times-circle"></i></a>
                                                                        @else
                                                                            <a class="btn btn-success btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('excluirContratos', [$unidade->id, $contrato->id, $contrato->ID]) }}">
                                                                                <i class="bi bi-check-lg"></i></a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p>
                                <a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#servicos"
                                    role="button" aria-expanded="false" aria-controls="collapseExample">
                                    SERVIÇOS <i class="fas fa-tools"></i>
                                </a>
                            </p>
                            <div class="collapse border-0" id="servicos">
                                <div class="card card-body border-0">
                                    <p>
                                        <a style="width:200px;" class="btn btn-success" data-toggle="collapse"
                                            href="#servicosPessoaFisica" role="button" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            PESSOA FÍSICA <i class="fas fa-user-alt"></i>
                                        </a>
                                        <a style="width:200px;" class="btn btn-success" data-toggle="collapse"
                                            href="#servicosPessoaJuridica" role="button" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            PESSOA JURÍDICA <i class="fas fa-user-tie"></i>
                                        </a>
                                    </p>
                                    <div class="collapse border-0" id="servicosPessoaFisica">
                                        <div class="card card-body border-0">
                                            <div class="container">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">CPF</th>
                                                            <th scope="col">Pessoa</th>
                                                            <th scope="col">Serviço</th>
                                                            <th scope="col">Prazo</th>
                                                            <th scope="col">Opções</th>
                                                            <th scope="col">Alterar</th>
                                                            <th scope="col">Gestor</th>
                                                            <th scope="col">Excluir</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($contratos as $contrato)
                                                            @if ($contrato->tipo_contrato == 'SERVIÇOS' && $contrato->tipo_pessoa == 'PESSOA FÍSICA')
                                                                <tr>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->cnpj_cpf }}">
                                                                        {{ $contrato->cnpj_cpf }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->prestador }}">
                                                                        {{ $contrato->prestador }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->objeto }}">
                                                                        {{ $contrato->objeto }}</td>
                                                                    <td>
                                                                        @if ($contrato->fim == null)
                                                                            'Tempo Indeterminado'
                                                                        @elseif($contrato->renovacao_automatica == 0)
                                                                            {{ date('d-m-Y', strtotime($contrato->fim)) }}
                                                                        @elseif($contrato->renovacao_automatica == 1)
                                                                            'Renovação Automática'
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a class="badge badge-pill badge-primary dropdown-toggle"
                                                                            type="button" href="dropdownMenuButton"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            Visualizar
                                                                        </a> <?php $id = 0; ?>
                                                                        <div id="div" class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton"
                                                                            style="font-size: 12px;">
                                                                            <?php if ($contrato->cadastro == 0 && $contrato->inativa == 0) {  ?>
                                                                            <a id="div" class="dropdown-item"
                                                                                href="{{ $contrato->file_path }}"
                                                                                target="_blank">1º Contrato</a>
                                                                            <?php } elseif ($contrato->cadastro == 1 && $contrato->inativa == 0) { ?>
                                                                            <a id="div" class="dropdown-item"
                                                                                href="{{ asset('storage/') }}/{{ $contrato->file_path }}"
                                                                                target="_blank">1º Contrato</a>
                                                                            <?php } ?> <?php $idC = 1; ?>
                                                                            <?php $aditivoVincula = 1; ?>
                                                                            @foreach ($aditivos as $aditivo)
                                                                                @if ($aditivo->contrato_id == $contrato->ID)
                                                                                    @if ($aditivo->opcao == 1)
                                                                                        <?php $id += 1;
                                                                                        if (substr($aditivo->vinculado, 0, 1) != $aditivoVincula) {
                                                                                            $id = 1;
                                                                                        }
                                                                                        ?>
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $id }}º
                                                                                                    Aditivo
                                                                                                    ({{ $aditivo->vinculado }})
                                                                                                </a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $id }}º
                                                                                                    Aditivo
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @endif
                                                                                        <?php $aditivoVincula = substr($aditivo->vinculado, 0, 1); ?>
                                                                                    @elseif($aditivo->opcao == 2)
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">Distrato
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">Distrato
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @endif
                                                                                    @else
                                                                                        <?php $idC += 1; ?>
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $idC }}º
                                                                                                    Contrato</a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $idC }}º
                                                                                                    Contrato</a></strong>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    <td> <a class="btn btn-info btn-sm"
                                                                            style="color: #FFFFFF;"
                                                                            href="{{ route('alterarContratos', [$unidade->id, $contrato->id, $contrato->ID]) }}"><i
                                                                                class="fas fa-edit"></i></a> </td>
                                                                    <td> <a class="btn btn-secondary btn-sm"
                                                                            style="color: #FFFFFF;"
                                                                            href="{{ route('responsavelCadastro', [$unidade->id, $contrato->id]) }}">
                                                                            <i class="bi bi-person-circle"></i></a> </td>
                                                                    <td>
                                                                        @if ($contrato->inativa == 0)
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('excluirContratos', [$unidade->id, $contrato->ID]) }}">
                                                                                <i class="fas fa-times-circle"></i></a>
                                                                        @else
                                                                            <a class="btn btn-success btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('excluirContratos', [$unidade->id, $contrato->ID]) }}">
                                                                                <i class="bi bi-check-lg"></i></a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse border-0" id="servicosPessoaJuridica">
                                        <div class="card card-body border-0">
                                            <div class="container">
                                                <table class="table table-hover table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th scope="col">CNPJ</th>
                                                            <th scope="col">Empresa</th>
                                                            <th scope="col">Serviço</th>
                                                            <th scope="col">Prazo</th>
                                                            <th scope="col">Opções</th>
                                                            <th scope="col">Alterar</th>
                                                            <th scope="col">Gestor</th>
                                                            <th scope="col">Excluir</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($contratos as $contrato)
                                                            @if ($contrato->tipo_contrato == 'SERVIÇOS' && $contrato->tipo_pessoa == 'PESSOA JURÍDICA')
                                                                <tr>
                                                                    <td>{{ $contrato->id }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->cnpj_cpf }}">
                                                                        {{ $contrato->cnpj_cpf }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->prestador }}">
                                                                        {{ $contrato->prestador }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->objeto }}">
                                                                        {{ $contrato->objeto }}</td>
                                                                    <td>
                                                                        @if ($contrato->fim == null)
                                                                            'Tempo Indeterminado'
                                                                        @elseif($contrato->renovacao_automatica == 0)
                                                                            {{ date('d-m-Y', strtotime($contrato->fim)) }}
                                                                        @elseif($contrato->renovacao_automatica == 1)
                                                                            'Renovação Automática'
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a class="badge badge-pill badge-primary dropdown-toggle"
                                                                            type="button" href="dropdownMenuButton"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            Visualizar
                                                                        </a> <?php $id = 0; ?>
                                                                        <div id="div" class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton"
                                                                            style="font-size: 12px;">
                                                                            <?php if ($contrato->cadastro == 0 && $contrato->inativa == 0) {  ?>
                                                                            <a id="div" class="dropdown-item"
                                                                                href="{{ $contrato->file_path }}"
                                                                                target="_blank">1º Contrato</a>
                                                                            <?php } elseif ($contrato->cadastro == 1 && $contrato->inativa == 0) { ?>
                                                                            <a id="div" class="dropdown-item"
                                                                                href="{{ asset('storage/') }}/{{ $contrato->file_path }}"
                                                                                target="_blank">1º Contrato</a>
                                                                            <?php } ?> <?php $idC = 1; ?>
                                                                            <?php $aditivoVincula = 1; ?>
                                                                            @foreach ($aditivos as $aditivo)
                                                                                @if ($aditivo->contrato_id == $contrato->ID)
                                                                                    @if ($aditivo->opcao == 1)
                                                                                        <?php $id += 1;
                                                                                        if (substr($aditivo->vinculado, 0, 1) != $aditivoVincula) {
                                                                                            $id = 1;
                                                                                        }
                                                                                        ?>
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $id }}º
                                                                                                    Aditivo
                                                                                                    ({{ $aditivo->vinculado }})
                                                                                                </a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $id }}º
                                                                                                    Aditivo
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @endif
                                                                                        <?php $aditivoVincula = substr($aditivo->vinculado, 0, 1); ?>
                                                                                    @elseif($aditivo->opcao == 2)
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">Distrato
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">Distrato
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @endif
                                                                                    @else
                                                                                        <?php $idC += 1; ?>
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $idC }}º
                                                                                                    Contrato</a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $idC }}º
                                                                                                    Contrato</a></strong>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </td>
                                                                    <td> <a class="btn btn-info btn-sm"
                                                                            style="color: #FFFFFF;"
                                                                            href="{{ route('alterarContratos', [$unidade->id, $contrato->id, $contrato->ID]) }}"><i
                                                                                class="fas fa-edit"></i></a> </td>
                                                                    <td> <a class="btn btn-secondary btn-sm"
                                                                            style="color: #FFFFFF;"
                                                                            href="{{ route('responsavelCadastro', [$unidade->id, $contrato->ID]) }}">
                                                                            <i class="bi bi-person-circle"></i></a> </td>
                                                                    <td>
                                                                        @if ($contrato->inativa == 0)
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('excluirContratos', [$unidade->id, $contrato->ID]) }}">
                                                                                <i class="fas fa-times-circle"></i></a>
                                                                        @else
                                                                            <a class="btn btn-success btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('excluirContratos', [$unidade->id, $contrato->ID]) }}">
                                                                                <i class="bi bi-check-lg"></i></a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p>
                                <a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#aquisicao"
                                    role="button" aria-expanded="false" aria-controls="collapseExample">
                                    AQUISIÇÃO DE BENS <i class="fas fa-people-carry"></i>
                                </a>
                            </p>
                            <div class="collapse border-0" id="aquisicao">
                                <div class="card card-body border-0">
                                    <p>
                                        <a style="width:200px;" class="btn btn-success" data-toggle="collapse"
                                            href="#aquisicaoPessoaFisica" role="button" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            PESSOA FÍSICA <i class="fas fa-user-alt"></i>
                                        </a>
                                        <a style="width:200px;" class="btn btn-success" data-toggle="collapse"
                                            href="#aquisicaoPessoaJuridica" role="button" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            PESSOA JURÍDICA <i class="fas fa-user-tie"></i>
                                        </a>
                                    </p>
                                    <div class="collapse border-0" id="aquisicaoPessoaFisica">
                                        <div class="card card-body border-0">
                                            <div class="container">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">CPF</th>
                                                            <th scope="col">Pessoa</th>
                                                            <th scope="col">Objeto</th>
                                                            <th scope="col">Prazo</th>
                                                            <th scope="col">Opções</th>
                                                            <th scope="col">Alterar</th>
                                                            <th scope="col">Gestor</th>
                                                            <th scope="col">Excluir</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($contratos as $contrato)
                                                            @if ($contrato->tipo_contrato == 'AQUISIÇÃO' && $contrato->tipo_pessoa == 'PESSOA FÍSICA')
                                                                <tr>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->cnpj_cpf }}">
                                                                        {{ $contrato->cnpj_cpf }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->prestador }}">
                                                                        {{ $contrato->prestador }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->objeto }}">
                                                                        {{ $contrato->objeto }}</td>
                                                                    <td>
                                                                        @if ($contrato->fim == null)
                                                                            'Tempo Indeterminado'
                                                                        @elseif($contrato->renovacao_automatica == 0)
                                                                            {{ date('d-m-Y', strtotime($contrato->fim)) }}
                                                                        @elseif($contrato->renovacao_automatica == 1)
                                                                            'Renovação Automática'
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a class="badge badge-pill badge-primary dropdown-toggle"
                                                                            type="button" href="dropdownMenuButton"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            Visualizar
                                                                        </a> <?php $id = 0; ?>
                                                                        <div id="div" class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton"
                                                                            style="font-size: 12px;">
                                                                            <?php if ($contrato->cadastro == 0 && $contrato->inativa == 0) {  ?>
                                                                            <a id="div" class="dropdown-item"
                                                                                href="{{ $contrato->file_path }}"
                                                                                target="_blank">1º Contrato</a>
                                                                            <?php } elseif ($contrato->cadastro == 1 && $contrato->inativa == 0) { ?>
                                                                            <a id="div" class="dropdown-item"
                                                                                href="{{ asset('storage/') }}/{{ $contrato->file_path }}"
                                                                                target="_blank">1º Contrato</a>
                                                                            <?php } ?> <?php $idC = 1; ?>
                                                                            <?php $aditivoVincula = 1; ?>
                                                                            @foreach ($aditivos as $aditivo)
                                                                                @if ($aditivo->contrato_id == $contrato->ID)
                                                                                    @if ($aditivo->opcao == 1)
                                                                                        <?php $id += 1;
                                                                                        if (substr($aditivo->vinculado, 0, 1) != $aditivoVincula) {
                                                                                            $id = 1;
                                                                                        }
                                                                                        ?>
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $id }}º
                                                                                                    Aditivo
                                                                                                    ({{ $aditivo->vinculado }})
                                                                                                </a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $id }}º
                                                                                                    Aditivo
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @endif
                                                                                        <?php $aditivoVincula = substr($aditivo->vinculado, 0, 1); ?>
                                                                                    @elseif($aditivo->opcao == 2)
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">Distrato
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">Distrato
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @endif
                                                                                    @else
                                                                                        <?php $idC += 1; ?>
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $idC }}º
                                                                                                    Contrato</a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $idC }}º
                                                                                                    Contrato</a></strong>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    <td> <a class="btn btn-info btn-sm"
                                                                            style="color: #FFFFFF;"
                                                                            href="{{ route('alterarContratos', [$unidade->id, $contrato->id, $contrato->ID]) }}"><i
                                                                                class="fas fa-edit"></i></a> </td>
                                                                    <td> <a class="btn btn-secondary btn-sm"
                                                                            style="color: #FFFFFF;"
                                                                            href="{{ route('responsavelCadastro', [$unidade->id, $contrato->ID]) }}">
                                                                            <i class="bi bi-person-circle"></i></a> </td>
                                                                    <td>
                                                                        @if ($contrato->inativa == 0)
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('excluirContratos', [$unidade->id, $contrato->ID]) }}">
                                                                                <i class="fas fa-times-circle"></i></a>
                                                                        @else
                                                                            <a class="btn btn-success btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('excluirContratos', [$unidade->id, $contrato->ID]) }}">
                                                                                <i class="bi bi-check-lg"></i></a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse border-0" id="aquisicaoPessoaJuridica">
                                        <div class="card card-body border-0">
                                            <div class="container">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">CNPJ</th>
                                                            <th scope="col">Empresa</th>
                                                            <th scope="col">Objeto</th>
                                                            <th scope="col">Prazo</th>
                                                            <th scope="col">Opções</th>
                                                            <th scope="col">Alterar</th>
                                                            <th scope="col">Gestor</th>
                                                            <th scope="col">Excluir</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($contratos as $contrato)
                                                            @if ($contrato->tipo_contrato == 'AQUISIÇÃO' && $contrato->tipo_pessoa == 'PESSOA JURÍDICA')
                                                                <tr>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->cnpj_cpf }}">
                                                                        {{ $contrato->cnpj_cpf }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->prestador }}">
                                                                        {{ $contrato->prestador }}</td>
                                                                    <td class="text-truncate" style="max-width: 100px;"
                                                                        title="{{ $contrato->objeto }}">
                                                                        {{ $contrato->objeto }}</td>
                                                                    <td>
                                                                        @if ($contrato->fim == null)
                                                                            'Tempo Indeterminado'
                                                                        @elseif($contrato->renovacao_automatica == 0)
                                                                            {{ date('d-m-Y', strtotime($contrato->fim)) }}
                                                                        @elseif($contrato->renovacao_automatica == 1)
                                                                            'Renovação Automática'
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a class="badge badge-pill badge-primary dropdown-toggle"
                                                                            type="button" href="dropdownMenuButton"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            Visualizar
                                                                        </a> <?php $id = 0; ?>
                                                                        <div id="div" class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton"
                                                                            style="font-size: 12px;">
                                                                            <?php if ($contrato->cadastro == 0 && $contrato->inativa == 0) {  ?>
                                                                            <a id="div" class="dropdown-item"
                                                                                href="{{ $contrato->file_path }}"
                                                                                target="_blank">1º Contrato</a>
                                                                            <?php } elseif ($contrato->cadastro == 1 && $contrato->inativa == 0) { ?>
                                                                            <a id="div" class="dropdown-item"
                                                                                href="{{ asset('storage/') }}/{{ $contrato->file_path }}"
                                                                                target="_blank">1º Contrato</a>
                                                                            <?php } ?> <?php $idC = 1; ?>
                                                                            <?php $aditivoVincula = 1; ?>
                                                                            @foreach ($aditivos as $aditivo)
                                                                                @if ($aditivo->contrato_id == $contrato->ID)
                                                                                    @if ($aditivo->opcao == 1)
                                                                                        <?php $id += 1;
                                                                                        if (substr($aditivo->vinculado, 0, 1) != $aditivoVincula) {
                                                                                            $id = 1;
                                                                                        }
                                                                                        ?>
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $id }}º
                                                                                                    Aditivo
                                                                                                    ({{ $aditivo->vinculado }})
                                                                                                </a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $id }}º
                                                                                                    Aditivo
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @endif
                                                                                        <?php $aditivoVincula = substr($aditivo->vinculado, 0, 1); ?>
                                                                                    @elseif($aditivo->opcao == 2)
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">Distrato
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">Distrato
                                                                                                    ({{ $aditivo->vinculado }})</a></strong>
                                                                                        @endif
                                                                                    @else
                                                                                        <?php $idC += 1; ?>
                                                                                        @if ($aditivo->ativa == 1 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $idC }}º
                                                                                                    Contrato</a></strong>
                                                                                        @elseif($aditivo->ativa == 0 && $aditivo->inativa == 0)
                                                                                            <strong><a id="div"
                                                                                                    class="dropdown-item"
                                                                                                    href="{{ asset('storage') }}/{{ $aditivo->file_path }}"
                                                                                                    target="_blank">{{ $idC }}º
                                                                                                    Contrato</a></strong>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    <td> <a class="btn btn-info btn-sm"
                                                                            style="color: #FFFFFF;"
                                                                            href="{{ route('alterarContratos', [$unidade->id, $contrato->id, $contrato->ID]) }}"><i
                                                                                class="fas fa-edit"></i></a> </td>
                                                                    <td> <a class="btn btn-secondary btn-sm"
                                                                            style="color: #FFFFFF;"
                                                                            href="{{ route('responsavelCadastro', [$unidade->id, $contrato->id]) }}">
                                                                            <i class="bi bi-person-circle"></i></a> </td>
                                                                    <td>
                                                                        @if ($contrato->inativa == 0)
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('excluirContratos', [$unidade->id, $contrato->ID]) }}">
                                                                                <i class="fas fa-times-circle"></i></a>
                                                                        @else
                                                                            <a class="btn btn-success btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('excluirContratos', [$unidade->id, $contrato->ID]) }}">
                                                                                <i class="bi bi-check-lg"></i></a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
