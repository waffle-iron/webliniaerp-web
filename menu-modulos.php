<?php if($_SESSION['user']['id_empreendimento'] == '75'){ ?>
	<li>
		<a href="produtos.php">
			<span class="submenu-label">
				<i class="fa fa-archive"></i> Produtos
			</span>
		</a>
	</li>
	<li>
		<a href="agendamento-consulta.php">
			<span class="submenu-label">
				<i class="fa fa-calendar"></i> Agenda de Atendimento
			</span>
		</a>
	</li>
	<li>
		<a href="controle-atendimento.php">
			<span class="submenu-label">
				<i class="fa fa-list"></i> Contr. de Atendimento
			</span>
		</a>
	</li>
	<li>
		<a href="controle_protese.php">
			<span class="submenu-label">
				<i class="fa fa-list-alt "></i> Contr. de Prótese
			</span>
		</a>
	</li>
	<li>
		<a href="procedimentos.php">
			<span class="submenu-label">
				<i class="fa fa-list-alt "></i> Procedimentos
			</span>
		</a>
	</li>
	<li>
		<a href="fabricantes.php">
			<span class="submenu-label">
				<i class="fa fa-puzzle-piece"></i> Fabricantes
			</span>
		</a>
	</li>
	<li>
		<a href="fornecedores.php">
			<span class="submenu-label">
				<i class="fa fa-truck"></i> Fornecedores
			</span>
		</a>
	</li>
	<li>
		<a href="importadores.php">
			<span class="submenu-label">
				<i class="fa fa-plane"></i> Importadores
			</span>
		</a>
	</li>
	<li>
		<a href="categorias.php">
			<span class="submenu-label">
				<i class="fa fa-tags"></i> Categorias
			</span>
		</a>
	</li>
	<li>
		<a href="lancamentos.php">
			<span class="submenu-label">
				<i class="fa fa-money"></i> Lanç. Financeiros
			</span>
		</a>
	</li>
	<li>
		<a href="vendas.php">
			<span class="submenu-label">
				<i class="fa fa-signal"></i> Vendas
			</span>
		</a>
	</li>
	<li>
		<a href="clientes.php">
			<span class="submenu-label">
				<i class="fa fa-users"></i> Clientes/Usuários
			</span>
		</a>
	</li>
	<li>
		<a href="grupo_comissao.php">
			<span class="submenu-label">
				<i class="fa fa-superscript"></i> Grupos de Comissão
			</span>
		</a>
	</li>
	<li>
		<a href="empreendimento_config.php">
			<span class="submenu-label">
				<i class="fa fa-cog"></i> Configurações
			</span>
		</a>
	</li>
	<li ng-if="userLogged.id_empreendimento == 6">
		<a href="empreendimentos.php">
			<span class="submenu-label">
				<i class="fa fa-building-o"></i> Empreendimentos
			</span>
		</a>
	</li>

	<li>
		<a href="depositos.php">
			<span class="submenu-label">
				<i class="fa fa-sitemap"></i> Depositos
			</span>
		</a>
	</li>
	<li>
		<a href="contas.php">
			<span class="submenu-label">
				<i class="fa fa-bank"></i> Contas Bancárias
			</span>
		</a>
	</li>
	<li>
		<a href="maquinetas.php">
			<span class="submenu-label">
				<i class="fa fa-fax"></i> Maquinetas de Cartão
			</span>
		</a>
	</li>
	<li>
		<a href="plano_contas.php">
			<span class="submenu-label">
				<i class="fa fa-code-fork"></i> Naturezas de Operação
			</span>
		</a>
	</li>
	<li>
		<a href="mapa.php">
			<span class="submenu-label">
				<i class="fa fa-map-marker"></i> Mapa de Clientes
			</span>
		</a>
	</li>
<?php }else{ ?>
	<li>
		<a href="produtos.php">
			<span class="submenu-label">
				<i class="fa fa-archive"></i> Produtos
			</span>
		</a>
	</li>
	<li>
		<a href="grade.php">
			<span class="submenu-label">
				<i class="fa fa-th"></i> Vitrine
			</span>
		</a>
	</li>
	<li>
		<a href="fabricantes.php">
			<span class="submenu-label">
				<i class="fa fa-puzzle-piece"></i> Fabricantes
			</span>
		</a>
	</li>
	<li>
		<a href="fornecedores.php">
			<span class="submenu-label">
				<i class="fa fa-truck"></i> Fornecedores
			</span>
		</a>
	</li>
	<li>
		<a href="importadores.php">
			<span class="submenu-label">
				<i class="fa fa-plane"></i> Importadores
			</span>
		</a>
	</li>
	<li>
		<a href="categorias.php">
			<span class="submenu-label">
				<i class="fa fa-tags"></i> Categorias
			</span>
		</a>
	</li>
	<li>
		<a href="lancamentos.php">
			<span class="submenu-label">
				<i class="fa fa-money"></i> Lanç. Financeiros
			</span>
		</a>
	</li>
	<li>
		<a href="controle-mesas.php">
			<span class="submenu-label">
				<i class="fa fa-table"></i> Controle de Mesas
			</span>
		</a>
	</li>
	<li>
		<a href="vendas.php">
			<span class="submenu-label">
				<i class="fa fa-signal"></i> Vendas
			</span>
		</a>
	</li>
	<li>
		<a href="caixas.php">
			<span class="submenu-label">
				<i class="fa fa-desktop"></i> Caixas (PDV)
			</span>
		</a>
	</li>
	<li>
		<a href="clientes.php">
			<span class="submenu-label">
				<i class="fa fa-users"></i> Clientes/Usuários
			</span>
		</a>
	</li>
	<li>
		<a href="grupo_comissao.php">
			<span class="submenu-label">
				<i class="fa fa-superscript"></i> Grupos de Comissão
			</span>
		</a>
	</li>
	<li>
		<a href="empreendimento_config.php">
			<span class="submenu-label">
				<i class="fa fa-cog"></i> Configurações
			</span>
		</a>
	</li>
	<li ng-if="userLogged.id_empreendimento == 6">
		<a href="empreendimentos.php">
			<span class="submenu-label">
				<i class="fa fa-building-o"></i> Empreendimentos
			</span>
		</a>
	</li>

	<li>
		<a href="depositos.php">
			<span class="submenu-label">
				<i class="fa fa-sitemap"></i> Depositos
			</span>
		</a>
	</li>
	<li>
		<a href="contas.php">
			<span class="submenu-label">
				<i class="fa fa-bank"></i> Contas Bancárias
			</span>
		</a>
	</li>
	<li>
		<a href="maquinetas.php">
			<span class="submenu-label">
				<i class="fa fa-fax"></i> Maquinetas de Cartão
			</span>
		</a>
	</li>
	<li>
		<a href="plano_contas.php">
			<span class="submenu-label">
				<i class="fa fa-code-fork"></i> Naturezas de Operação
			</span>
		</a>
	</li>
	 <li>
		<a href="faixa_desconto_permitido.php">
			<span class="submenu-label">
				<i class="fa fa-star-half"></i> Autorizar Descontos 
			</span>
		</a>
	</li>
	<li>
		<a href="faixa_desconto.php">
			<span class="submenu-label">
				<i class="fa fa-dot-circle-o"></i> Faixas de Desconto
			</span>
		</a>
	</li>
	<li>
		<a href="mapa.php">
			<span class="submenu-label">
				<i class="fa fa-map-marker"></i> Mapa de Clientes
			</span>
		</a>
	</li>
<?php } ?>