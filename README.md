# scpsa

Modelagem "Atividade" (não é evento);

titulo VARCHAR(250)
descricao LONGTEXT
responsavel INT
projeto INT
programa INT
periodo_inicio DATE
periodo_fim DATE
ano_base INT(4)



Empenho fracionado


Modelagem "Orçamento"

titulo VARCHAR(250)
projeto INT
ficha INT
dotacao VARCHAR
fonte VARCHAR
valor Double
data_liberacao DATE

Modelagem movimentação orçamentária
titulo VARCHAR(250)
tipo (INT) / Tipo
	+ contigenciamento
	+ descontigenciamento
	+ suplementado
data DATE
valor Double


contratação artística 
contratação de infraestrutura

Modelagem ATA




pj
pf
contrato
evento
	

