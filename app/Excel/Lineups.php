<?php

namespace App\Excel;

class Lineups extends Excel
{
    public $data;

    /**
     * Create a Excel instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        parent::__construct();
        $this->data = $data;
    }

    /**
     * Build the Excel.
     *
     * @return void
     */
    public function build(): void
    {
        $this->value('A1', 'Local');

        $this->value('A2', 'Equipo titular');
        $this->value('B2', $this->data['local']['team']);

        $this->value('A3', 'Numero de camiseta');
        $this->value('B3', 'Nombre de jugador');

        $i = 4;

        foreach ($this->data['local']['startXI'] as $item) {
            $this->value('A' . $i, $item['number']);
            $this->value('B' . $i, $item['name']);

            $i++;
        }

        $this->value('A' . $i, 'Suplentes');

        $i++;

        $this->value('A' . $i, 'Numero de camiseta');
        $this->value('B' . $i, 'Nombre de jugador');

        $i++;

        foreach ($this->data['local']['substitutes'] as $item) {
            $this->value('A' . $i, $item['number']);
            $this->value('B' . $i, $item['name']);

            $i++;
        }

        $this->value('A' . $i, 'Nombre del técnico');
        $this->value('B' . $i, $this->data['local']['coach']);

        $this->autosize('A');
        $this->autosize('B');

        $this->value('D1', 'Visitante');

        $this->value('D2', 'Equipo titular');
        $this->value('E2', $this->data['away']['team']);

        $this->value('D3', 'Numero de camiseta');
        $this->value('E3', 'Nombre de jugador');

        $i = 4;

        foreach ($this->data['away']['startXI'] as $item) {
            $this->value('D' . $i, $item['number']);
            $this->value('E' . $i, $item['name']);

            $i++;
        }

        $this->value('D' . $i, 'Suplentes');

        $i++;

        $this->value('D' . $i, 'Numero de camiseta');
        $this->value('E' . $i, 'Nombre de jugador');

        $i++;

        foreach ($this->data['away']['substitutes'] as $item) {
            $this->value('D' . $i, $item['number']);
            $this->value('E' . $i, $item['name']);

            $i++;
        }

        $this->value('D' . $i, 'Nombre del técnico');
        $this->value('E' . $i, $this->data['away']['coach']);

        $this->autosize('D');
        $this->autosize('E');
    }
}
