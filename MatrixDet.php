<?php
/**
 * Created by PhpStorm.
 * User: neduck
 * Date: 06/10/2018
 * Time: 18:50
 */

namespace App;

class MatrixDet
{
    /**
     * @var array
     */
    private $matrix;

    /**
     * @var int|float
     */
    private $det;

    /**
     * MatrixDet constructor.
     *
     * @param array $matrix
     *
     * @throws InvalidMatrixFormatException
     */
    public function __construct(array $matrix)
    {
        $this->validateMatrix($matrix);
        $this->matrix = $matrix;
    }

    /**
     * @return int|float
     */
    public function getDet()
    {
        if (null === $this->det) {
            $this->det = $this->det($this->matrix);
        }
        return $this->det;
    }

    /**
     * @param array $matrix
     *
     * @return float|int
     */
    private function det(array $matrix)
    {
        if (\count($matrix) === 2) {
            return $matrix[0][0] * $matrix[1][1] - $matrix[0][1] * $matrix[1][0];
        }

        $total = 0;
        foreach ($matrix[0] as $j => $jValue) {
            $minor  = [];
            $minorI = 0;
            foreach ($matrix as $i => $i1Value) {
                $minorJ = 0;
                if ($i === 0) {
                    continue;
                }
                foreach ($matrix[$i] as $j1 => $j1Value) {
                    if ($j1 === $j) {
                        continue;
                    }
                    $minor[$minorI][$minorJ] = $j1Value;
                    $minorJ++;
                }
                $minorI++;
            }
            $det   = $this->det($minor);
            $total += (-1) ** ($j + 2) * $jValue * $det;
        }

        return $total;
    }


    /**
     * @return array
     */
    public function getMatrix(): array
    {
        return $this->matrix;
    }

    /**
     * @param array $matrix
     *
     * @return bool
     * @throws InvalidMatrixFormatException
     */
    private function validateMatrix(array $matrix): bool
    {
        $count = \count($matrix);

        if (2 > $count) {
            throw new InvalidMatrixFormatException('Matrix is too small');
        }

        foreach ($matrix as $row) {
            if (\count($row) !== $count) {
                throw new InvalidMatrixFormatException('Matrix should be square');
            }

            foreach ($row as $item) {
                if (!\is_numeric($item)) {
                    throw new InvalidMatrixFormatException(
                        sprintf('Invalid matrix format: item "%s" should be numeric', $item)
                    );
                }
            }
        }

        return true;
    }
}