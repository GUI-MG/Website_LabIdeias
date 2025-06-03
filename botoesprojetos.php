<?php 
    if (isset($_GET['projeto'])) {
        $projeto = $_GET['projeto'];

        if($projeto == 'sece') {
            echo "<p>O IFRS campus Feliz oferece cursos de níveis médio e superior que possibilitam a realização de estágios, obrigatórios ou não, com o objetivo de aproximar os alunos do mercado de trabalho. O setor de estágio do campus organiza e controla o processo, exigindo a entrega de documentos e relatórios. Devido ao grande volume de dúvidas semelhantes enviadas por e-mail, surgiu a necessidade de automatizar as respostas por meio de um chatbot integrado ao site da instituição, visando agilizar e tornar o atendimento mais eficiente.</p>";       
        }

        if($projeto == 'mchat') {
            echo "<p>O projeto propõe a criação de uma página web para tornar mais eficiente o diagnóstico do Transtorno do Espectro Autista (TEA) em crianças, automatizando o processo atualmente feito manualmente por médicos com o apoio de instituições como a APAE. O sistema online permitirá que os pais respondam remotamente a um questionário cujas respostas serão analisadas por uma fórmula matemática, gerando um diagnóstico automático. O objetivo é agilizar o processo, otimizando o tempo dos profissionais de saúde e promovendo um diagnóstico precoce e preciso, essencial para garantir melhor qualidade de vida aos pacientes.</p>";
        }

        if($projetos == 'website_projeto') {
            echo "<p>O projeto Laboratório de Ideias, do IFRS Campus Feliz, visa reunir e debater demandas para transformá-las em projetos práticos. Diante do número crescente de iniciativas desenvolvidas, surgiu a necessidade de criar um website que reúna informações sobre todos os projetos já realizados, seus autores, ilustrações e dados relevantes. O site também permitirá que pessoas externas ao projeto submetam novas ideias ou demandas, contribuindo para a continuidade e renovação das ações do projeto.</p>";
        }
        
        if($projeto == 'website_grupo') {
            echo "Colocar resumo ainda.";
        }

        if($projeto == 'app_enchentes') {
            echo "<p>Devido às enchentes no Rio Grande do Sul em maio, identificou-se a dificuldade na mobilização de ajuda por falta de comunicação entre voluntários e pessoas afetadas. Como solução, propõe-se a criação de um aplicativo que facilite essa conexão, especialmente na região do Vale do Caí, com potencial de expansão para todo o estado. O objetivo é desenvolver um modelo teórico do app, que contará com interface simples, sistema de geolocalização similar ao Google Maps e funcionalidades como criação de eventos, pedidos de ajuda e gerenciamento de doações (alimentos, roupas, mão de obra, etc.). O app visa tornar mais eficiente a organização da assistência em desastres climáticos atuais e futuros.</p>";
        }
    
    }


?>



/*<button><h4>SECE</h4></button>
      <p>O IFRS campus Feliz criou um chatbot no site para automatizar respostas sobre estágios, agilizando o atendimento aos alunos.<br></p>      
      <p>O IFRS campus Feliz oferece cursos de níveis médio e superior que possibilitam a realização de estágios, obrigatórios ou não, com o objetivo de aproximar os alunos do mercado de trabalho. O setor de estágio do campus organiza e controla o processo, exigindo a entrega de documentos e relatórios. Devido ao grande volume de dúvidas semelhantes enviadas por e-mail, surgiu a necessidade de automatizar as respostas por meio de um chatbot integrado ao site da instituição, visando agilizar e tornar o atendimento mais eficiente.</p>
      <button><h4>MCHAT</h4></button>
        <p>O projeto propõe a criação de uma página web para automatizar o diagnóstico do Transtorno do Espectro Autista (TEA) em crianças, agilizando o processo e promovendo diagnósticos precoces e precisos.<br></p>
        <p>O projeto propõe a criação de uma página web para tornar mais eficiente o diagnóstico do Transtorno do Espectro Autista (TEA) em crianças, automatizando o processo atualmente feito manualmente por médicos com o apoio de instituições como a APAE. O sistema online permitirá que os pais respondam remotamente a um questionário cujas respostas serão analisadas por uma fórmula matemática, gerando um diagnóstico automático. O objetivo é agilizar o processo, otimizando o tempo dos profissionais de saúde e promovendo um diagnóstico precoce e preciso, essencial para garantir melhor qualidade de vida aos pacientes.</p>
      <button><h4>Website do Projeto</h4></button>
      <p>O projeto Laboratório de Ideias do IFRS Campus Feliz criou um site para centralizar informações sobre projetos realizados e permitir a submissão de novas ideias e demandas.<br></p>
        <p>O projeto Laboratório de Ideias, do IFRS Campus Feliz, visa reunir e debater demandas para transformá-las em projetos práticos. Diante do número crescente de iniciativas desenvolvidas, surgiu a necessidade de criar um website que reúna informações sobre todos os projetos já realizados, seus autores, ilustrações e dados relevantes. O site também permitirá que pessoas externas ao projeto submetam novas ideias ou demandas, contribuindo para a continuidade e renovação das ações do projeto.</p>
      <button><h4>Website do Grupo</h4></button>
        <p>O website do grupo será desenvolvido com o intuito de unir todos os projetos e acontecimentos que foram realizados pelo grupo de pesquisas, ensino e extensão do IFRS Campus Feliz.<br></p>
        <p>Resumo mais aprofundado do projeto</p>
      <button><h4>App de ajuda nas enchentes</h4></button>
      <p>O projeto propõe a criação de um aplicativo para facilitar a comunicação e mobilização de ajuda durante enchentes no Rio Grande do Sul, com funcionalidades de geolocalização e gerenciamento de doações.<br></p>
        <p>Devido às enchentes no Rio Grande do Sul em maio, identificou-se a dificuldade na mobilização de ajuda por falta de comunicação entre voluntários e pessoas afetadas. Como solução, propõe-se a criação de um aplicativo que facilite essa conexão, especialmente na região do Vale do Caí, com potencial de expansão para todo o estado. O objetivo é desenvolver um modelo teórico do app, que contará com interface simples, sistema de geolocalização similar ao Google Maps e funcionalidades como criação de eventos, pedidos de ajuda e gerenciamento de doações (alimentos, roupas, mão de obra, etc.). O app visa tornar mais eficiente a organização da assistência em desastres climáticos atuais e futuros.</p>
    </div>*/
