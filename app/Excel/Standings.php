<?php

namespace App\Excel;

class Standings extends Excel
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
        $this->value('A1', 'Posicion');
        $this->value('B1', 'Nombre del equipo');
        $this->value('C1', 'Partidos disputados');
        $this->value('D1', 'Puntos');

        $i = 2;

        foreach ($this->data as $item) {
            $this->value('A' . $i, $item['position']);
            $this->value('B' . $i, $item['team']);
            $this->value('C' . $i, $item['played']);
            $this->value('D' . $i, $item['points']);

            $i++;
        }

        $this->autosize('A');
        $this->autosize('B');
        $this->autosize('C');
        $this->autosize('D');
    }
}
